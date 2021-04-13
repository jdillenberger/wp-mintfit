#!/usr/bin/env bash

ARCHIVE_NAME='wp-mintfit'

if ! command -v 'npm' &> /dev/null
then
    echo "NPM is not installed. Please install npm and then restart this script."
    exit
fi

# reset subshell
set -e

CURRENT_DIRECTORY=`realpath $(dirname $0)`

pushd "$CURRENT_DIRECTORY"
    
    VERSION=`git branch --show-current`
    
    npm install
    npm run build

    rm -f "./${ARCHIVE_NAME}.${VERSION}.zip"
    zip -r "${ARCHIVE_NAME}.${VERSION}.zip" . -x './node_modules/*'  './js/*' '*.git*' './README.md' './*.json' './*.sh' '*~*' './webpack*' '*.log' 'Vagrantfile' './*.config.js'

popd

echo "${ARCHIVE_NAME} was build '${CURRENT_DIRECTORY}/${ARCHIVE_NAME}.${VERSION}.zip'"
