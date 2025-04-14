import { F } from "@effectualjs/core";

import "./Icon.css";

export interface Props {
    name: string;
    size?: number;
    class?: string;
}

export interface Ctx {
    emits: {
        click?: () => void;
    };
}

export const Icon = (props: Props, ctx: Ctx) => {
    return (
        <div
            class={`icon ${props.class ?? ""}`}
            data-size={props.size ?? 1.5}
            data-has-click={!!ctx.emits.click}
            $on:click={ctx.emits.click}
        >
            {props.name}
        </div>
    );
};
