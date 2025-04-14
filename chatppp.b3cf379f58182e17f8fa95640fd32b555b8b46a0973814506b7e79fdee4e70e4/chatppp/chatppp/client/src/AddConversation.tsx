import { F } from "@effectualjs/core";
import { $state } from "@effectualjs/reconciler";

import { Button } from "./Button.js";
import { TextInput } from "./TextInput.js";

import "./AddConversation.css";

export interface Props {}

export interface Ctx {
    emits: {
        create: (name: string) => void;
        close: () => void;
    };
}

export const AddConversation = (props: Props, ctx: Ctx) => {
    const name = $state("");

    const create = () => {
        ctx.emits.create(name.value);
        ctx.emits.close();
        name.setValue("");
    };

    return (
        <div class="add-conversation-modal">
            <TextInput
                placeholder="Lonesome Lorrie"
                value={name.value}
                $on:change={(value) => name.setValue(value)}
                $on:submit={create}
            />
            <Button $on:click={create}>Chat with {name.value}</Button>
        </div>
    );
};
