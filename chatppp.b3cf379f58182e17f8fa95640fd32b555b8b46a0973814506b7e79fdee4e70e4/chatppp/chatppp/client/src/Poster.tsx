import { F } from "@effectualjs/core";

import "./Poster.css";

export interface Props {}

export interface Ctx {
    slots: {
        title: F.Element;
        "header-cta"?: F.Element;
    };
}

export const Poster = (_props: Props, _ctx: Ctx) => {
    return (
        <div class="poster">
            <div class="poster-content">
                <div class="poster-header">
                    <div class="thumbtack" />

                    <div class="poster-header-content">
                        <div>ChatPPP</div>
                        <slot name="header-cta" />
                    </div>

                    <div class="thumbtack" />
                </div>

                <div class="poster-body">
                    <slot />
                </div>

                <div class="poster-title">
                    <slot name="title" />
                </div>
            </div>
        </div>
    );
};
