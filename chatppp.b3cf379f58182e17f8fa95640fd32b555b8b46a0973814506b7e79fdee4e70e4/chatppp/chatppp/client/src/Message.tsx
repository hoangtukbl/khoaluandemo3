import { F } from "@effectualjs/core";
import { $effect } from "@effectualjs/reconciler";

import { Icon } from "./Icon.js";
import { Markdown } from "./Markdown.js";

import "./Message.css";

export interface MessageProps {
    body: string;
    timestamp: string;
    origin: "user" | "bot";
    id?: string;
}

export interface MessageCtx {
    emits: {
        share?: () => void;
    };
}

export const Message = (props: MessageProps, ctx: MessageCtx) => {
    const formattedTime = $effect(
        (timestamp) => {
            const date = new Date(timestamp);
            return date.toLocaleTimeString(undefined, {
                month: "long",
                day: "numeric",
                hour12: true,
                hour: "numeric",
                minute: "numeric",
            });
        },
        [props.timestamp],
    );

    return (
        <div id={props.id} class="chat-message" data-origin={props.origin}>
            <div class="message-time">{formattedTime}</div>
            <div class="message-body">
                <Markdown body={props.body} />
            </div>
            {ctx.emits.share ? (
                <div class="message-actions">
                    <Icon name="share" size={1.5} $on:click={ctx.emits.share} />
                </div>
            ) : null}
        </div>
    );
};
