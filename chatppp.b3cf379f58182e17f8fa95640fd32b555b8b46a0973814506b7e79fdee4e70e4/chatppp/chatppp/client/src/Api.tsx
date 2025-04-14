import { Conversation, ModelConfig } from "./hooks.js";

export const progressChat = async (conversation: Conversation, config: Partial<ModelConfig>): Promise<Conversation> => {
    const response = await fetch("/api/chat/advance", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ conversation, config }),
    });

    if (!response.ok) {
        throw new Error("Failed to advance conversation");
    }

    return await response.json();
};

export const saveChat = async (conversation: Conversation): Promise<string> => {
    const response = await fetch("/api/chat/save", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ conversation }),
    });

    if (!response.ok) {
        throw new Error("Failed to save conversation");
    }

    return await response.json();
};

export const loadChat = async (uid: string): Promise<Conversation | null> => {
    const query = new URLSearchParams({ uid });
    const response = await fetch(`/api/chat/load?${query.toString()}`);
    if (!response.ok) {
        throw new Error("Failed to load conversation");
    }

    return await response.json();
};

export const shareWithAdmin = async (url: string) => {
    const res = await fetch("/api/share/admin", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ url }),
    });

    await res.text();
};
