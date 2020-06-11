#!/usr/bin/env bash

gpg --quiet --batch --yes --decrypt --passphrase="$ENV_PASSPHRASE" --output ./.env.test ./.github/secrets/.env.asc