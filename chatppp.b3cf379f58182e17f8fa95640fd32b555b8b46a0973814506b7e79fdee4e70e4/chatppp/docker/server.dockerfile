FROM node:22-alpine AS chatppp-client

WORKDIR /app/effectual

COPY effectual/yarn.lock effectual/.yarnrc.yml ./
COPY effectual/.yarn ./.yarn

RUN --mount=type=cache,sharing=locked,id=yarn,target=./.yarn/cache yarn fetch
COPY effectual .
RUN --mount=type=cache,sharing=locked,id=yarn,target=./.yarn/cache yarn
RUN yarn r core:build

WORKDIR /app/chatppp

COPY chatppp/.yarn ./.yarn
COPY chatppp/package.json ./package.json
COPY chatppp/yarn.lock ./yarn.lock
COPY chatppp/.yarnrc.yml ./.yarnrc.yml

WORKDIR /app/chatppp

COPY chatppp .
RUN --mount=type=cache,sharing=locked,id=yarn,target=./.yarn/cache yarn workspaces focus @chatppp/client
RUN yarn r client:build

FROM node:22-bookworm AS chatppp

RUN apt update && apt install -y chromium
WORKDIR /app/chatppp

COPY chatppp/.yarn ./.yarn
COPY chatppp/package.json ./package.json
COPY chatppp/yarn.lock ./yarn.lock
COPY chatppp/.yarnrc.yml ./.yarnrc.yml

WORKDIR /app/chatppp

COPY chatppp .
RUN --mount=type=cache,sharing=locked,id=yarn,target=./.yarn/cache yarn workspaces focus @chatppp/server
RUN yarn r server:build

COPY --from=chatppp-client /app/chatppp/client/dist ./client/dist

WORKDIR /app/chatppp/server
CMD ["node", "--preserve-symlinks", "dist/server.js"]