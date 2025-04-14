import { F } from "@effectualjs/core";

import "./TextInput.css";

export interface Props {
    value?: string;
    placeholder?: string;
}

export type Context = {
    emits: {
        change: (value: string) => void;
        submit?: () => void;
    };
    slots: {
        label?: F.Element;
    };
};

export const TextInput = (props: Props, ctx: Context) => {
    const keyUp = (e: KeyboardEvent) => {
        if (e.key === "Enter") {
            ctx.emits.submit?.();
        }
    };

    return (
        <div class="text-input-container">
            <label class="vanishing">{ctx.slots.label}</label>
            <input
                class="text-input"
                type="text"
                value={props.value}
                placeholder={props.placeholder}
                $on:input={(e: InputEvent) => ctx.emits.change((e.target as HTMLInputElement).value)}
                $on:keyup={keyUp}
            />
        </div>
    );
};
