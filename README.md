# RD_00000011_Starter_Theme_WP

Go to the theme directory and take a look at Readme.md for more informations

## Init

Clone the projet, and run `init.sh` script.

This will ask you for a project name and slug, and replace all the 'starter' stuff with the right names.

## Deployment

We use [Wordmove](https://github.com/welaika/wordmove).

First, install Wordmove (globally) :

`gem install wordmove`

Then run :

Recette : `wordmove push -e recette -t`

Production : `wordmove push -e production -t`

Wordmove will do a `npm run prod` for you before each deployment.