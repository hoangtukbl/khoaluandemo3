import { F, Store } from "@effectualjs/core";

import { $provideRouter } from "./hooks.js";
import { Main } from "./Main.js";
import { Router } from "./Router.js";
import { Share } from "./Share.js";

import "./index.css";

export interface Props {}

export const Count = Store.create(0);

export const App = (props: Props) => {
    $provideRouter();

    return (
        <Router
            routes={[
                { path: "/", component: Main },
                { path: "/share/:id", component: Share },
            ]}
        />
    );
};
