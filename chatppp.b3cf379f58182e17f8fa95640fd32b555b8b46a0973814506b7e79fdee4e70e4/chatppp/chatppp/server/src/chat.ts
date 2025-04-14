export type Message = {
    body: string;
    timestamp: string;
    origin: "user" | "bot";
};

export type Conversation = {
    name: string;
    messages: Message[];
};

export type ModelConfig = {
    userName?: string;
    token?: string;
};

const TOKEN = process.env.OPENAI_KEY || undefined;
const systemPrompt = (name: string) =>
    `You are ${name}, a character from the wild west. You should come up with a persona based off your name, and stick to it for the duration of the conversation. Try to give it a unique flair that is specific to this individual.`;

export const progressConversation = async (conversation: Conversation, config: ModelConfig): Promise<Conversation> => {
    const endpoint = "https://api.openai.com/v1/chat/completions";
    const token = config.token ?? TOKEN;

    const body = {
        model: "gpt-4o-mini",
        messages: [
            { role: "system", content: systemPrompt(conversation.name) },
            { role: "system", content: `You are now talking to ${config.userName}.` },
            ...conversation.messages.map((msg) => ({
                role: msg.origin === "user" ? "user" : "assistant",
                content: msg.body,
            })),
        ],
    };

    const response = await fetch(endpoint, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify(body),
        redirect: "error",
    });

    if (!response.ok) {
        console.log(await response.text());
        return {
            name: conversation.name,
            messages: [
                ...conversation.messages,
                {
                    body: "Well dang partner, ya got me.",
                    timestamp: new Date().toISOString(),
                    origin: "bot",
                },
            ],
        };
    }

    const data = await response.json();

    return {
        name: conversation.name,
        messages: [
            ...conversation.messages,
            {
                body: data.choices[0].message.content,
                timestamp: new Date().toISOString(),
                origin: "bot",
            },
        ],
    };
};
