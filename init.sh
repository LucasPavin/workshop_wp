#!/usr/bin/env bash

# Script d'initialisation du thème
echo "Project name (ex. 'Starter Theme') :"
read PROJECT
echo

echo "Project slug (ex. 'starter-theme') :"
read SLUG
echo

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"

if [ -z "$PROJECT" ] && [ -z "$SLUG" ]
then
	echo "Project name and slug are required. Aborting."
else
	echo "Project $PROJECT with slug $SLUG init ..."
	echo

	read -p "Theme directory will be ${SLUG}. Ok (O/n) ?" -n 1 -r
	echo
	echo

	if [[ $REPLY =~ ^[OoYy]$ ]]
	then

		# Replacing project name in files
	    echo "Replacing project name in files"
		eval "sed -i '' 's/RD_00000011_Starter_Theme_WP/${PROJECT}/g' ${DIR}/README.md"
		eval "sed -i '' 's/RD_00000011_Starter_Theme_WP/${PROJECT}/g' ${DIR}/wp-content/themes/starter/README.md"
		echo 'Done.'
		echo

		# Replacing slug in files
		echo "Replacing slug in files"
		FILES='.gitignore movefile.yml'
		for FILE in $FILES
		do
			FILE="${DIR}/${FILE}"
			if [ -f "$FILE" ]; then
			    eval "sed -i '' 's/starter/${SLUG}/g' ${FILE}"
			fi
		done

		# Some other replacements
		eval "sed -i '' 's/rd_00000011_starter_theme_wp/${SLUG}/g' ${DIR}/wp-content/themes/starter/package.json"
		eval "sed -i '' 's/rd_00000011_starter_theme_wp/${SLUG}/g' ${DIR}/wp-content/themes/starter/package-lock.json"
		eval "sed -i '' 's/wordpress-starter-theme/${SLUG}/g' ${DIR}/wp-content/themes/starter/composer.json"

		echo 'Done.'
		echo

		# Renaming theme directory
		echo "Renaming theme directory"
		eval "mv -f ${DIR}/wp-content/themes/starter/ ${DIR}/wp-content/themes/${SLUG}"
		echo 'Done.'
		echo

	fi

fi