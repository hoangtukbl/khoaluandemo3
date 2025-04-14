import { $effect, AssignableStore, F } from "@effectualjs/core";

import { saveChat } from "./Api.js";
import { Button } from "./Button.js";
import { $useMessageLog, ModelConfig } from "./hooks.js";
import { Message } from "./Message.js";
import { TextInput } from "./TextInput.js";

import "./Chat.css";

const TextBox = new AssignableStore("");

export interface ChatProps {
    config: Partial<ModelConfig>;
}

export const Chat = (props: ChatProps) => {
    const textBox = TextBox.$provide();
    const { messages, sendMessage, name } = $useMessageLog(props.config);

    const onSubmit = () => {
        sendMessage(textBox.value);
        textBox.setValue("");
    };

    $effect(
        (messages) => {
            setTimeout(() => {
                const el = document.querySelector(`#_chat-${messages.length - 1}`);
                el?.scrollIntoView({ behavior: "smooth" });
            }, 1);
        },
        [messages],
    );

    const share = async (idx: number) => {
        const uid = await saveChat({ messages, name });
        const url = new URL(`/share/${uid}#${idx}`, window.location.href);
        window.open(url, "_blank");
    };

    return (
        <div class="chat-wrapper">
            <div class="chat-messages">
                {messages.map((msg, i) => (
                    <Message key={i} id={`_chat-${i}`} $on:share={() => share(i)} {...msg} />
                ))}
            </div>

            <div class="chat-input">
                <ChatInput $on:submit={onSubmit} />
            </div>
        </div>
    );
};

interface ChatInputCtx {
    emits: {
        submit: () => void;
    };
}

export const ChatInput = (_props: {}, ctx: ChatInputCtx) => {
    const [value, setValue] = TextBox.$use();

    return (
        <div class="chat-input">
            <TextInput placeholder="Howdy!" value={value} $on:change={setValue} $on:submit={() => ctx.emits.submit()} />
            <Button class="chat-submit" $on:click={() => ctx.emits.submit()}>
                Submit
            </Button>
        </div>
    );
};
