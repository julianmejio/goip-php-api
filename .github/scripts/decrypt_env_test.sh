#!/usr/bin/env bash

gpg --quiet --batch --yes --decrypt --passphrase="$ENV_PASSPHRASE" --output $HOME/.env.test ../secrets/.env.asc