import { createElement, F } from "@effectualjs/core";

import { $useRoute } from "./hooks.js";

export interface RouteProps {
    matches: Record<string, string | null>;
}

export type Route = {
    path: string;
    component: (props: RouteProps) => F.Element;
};

export interface Props {
    routes: Route[];
}

export const matchRoute = (path: string, routePath: string) => {
    const routeParts = routePath.split("/");
    const pathParts = path.split("/");

    const matches: Record<string, string | null> = Object.create(null);

    for (let i = 0; i < routeParts.length; i++) {
        const routePart = routeParts[i];
        const pathPart = pathParts[i];

        let routeParam = routePart;
        let allowOptional = false;
        if (routeParam.slice(-1) === "?") {
            routeParam = routeParam.slice(0, -1);
            allowOptional = true;
        }

        if (routeParam[0] === ":") {
            if (pathPart !== undefined) {
                matches[routePart.slice(1)] = pathPart;
            } else if (allowOptional) {
                matches[routePart.slice(1)] = null;
            } else {
                return null;
            }

            continue;
        }

        if (routePart !== pathPart) {
            return null;
        }
    }

    if (pathParts.length !== routeParts.length) {
        return null;
    }

    return matches;
};

export const Router = (props: Props) => {
    const route = $useRoute();

    for (const routeDef of props.routes) {
        const matches = matchRoute(route, routeDef.path);
        if (matches !== null) {
            return createElement(routeDef.component as any, { matches });
        }
    }

    return null;
};
