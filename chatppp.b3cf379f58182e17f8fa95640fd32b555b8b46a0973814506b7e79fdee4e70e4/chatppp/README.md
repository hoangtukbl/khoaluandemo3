# First build

To get this running locally, do the following:

In the effectual package, run

```bash
yarn
yarn r core:build
```

The first build will error, the second will succeed. Hopefully before i release this i can make ts build mode work.

Then in the chatppp directory, run

```bash
yarn
yarn r client:build
yarn r server:build
yarn r server
```

Then it should be running at localhost:3030

# Problem goal

Your job is to get XSS on a page that you can send the attacker to. To test that you have it sufficiently working, put something into localStorage and try to read it off the victim.