import { F } from "@effectualjs/core";

import { cls } from "./utils.js";

import "./Button.css";

export interface Props {
    class?: string;
}

export interface Ctx {
    emits: {
        click?: () => void;
    };
}

export const Button = (props: Props, ctx: Ctx) => {
    return (
        <button class={cls("button", props.class)} $on:click={ctx.emits.click}>
            <slot />
        </button>
    );
};
