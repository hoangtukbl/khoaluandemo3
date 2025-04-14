import { F } from "@effectualjs/core";

import { Button } from "./Button.js";
import { ModelConfig } from "./hooks.js";
import { TextInput } from "./TextInput.js";

import "./Config.css";

export interface Props {
    config: Partial<ModelConfig>;
}

export interface Ctx {
    emits: {
        close: () => void;
        configChange: (config: Partial<ModelConfig>) => void;
    };
}

export const Config = (props: Props, ctx: Ctx) => {
    return (
        <div class="config-view">
            <form class="config-form" $on:submit={(e: SubmitEvent) => e.preventDefault()}>
                <TextInput
                    value={props.config.userName}
                    placeholder="zwad3"
                    $on:change={(value) => ctx.emits.configChange({ ...props.config, userName: value || undefined })}
                    $slot:label="Your Name"
                />
                <TextInput
                    value={props.config.token}
                    placeholder={"sk-proj-...."}
                    $on:change={(value) => ctx.emits.configChange({ ...props.config, token: value || undefined })}
                    $slot:label="Personal OpenAI Token"
                />
                <Button $on:click={() => ctx.emits.close()}>Save and Close</Button>
            </form>
        </div>
    );
};
