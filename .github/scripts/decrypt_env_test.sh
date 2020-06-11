#!/usr/bin/env bash

gpg --quiet --batch --yes --decrypt --passphrase="$ENV_PASSPHRASE" --output $HOME/.env.test $HOME/.github/secrets/.env.asc