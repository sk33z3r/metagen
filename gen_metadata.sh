#!/usr/bin/env bash

# change to the name of the NFT collection
COLLECTION="FryPhone"

# change this to the top-level CID for your image folders
thumbCID="QmYfhkvAKiA93bMBhSSDhW28sAUuE5VdeUDyKxPAYqF1Xd"
fullCID="QmYfhkvAKiA93bMBhSSDhW28sAUuE5VdeUDyKxPAYqF1Xd"

# set royalty percentage
royalty=0

# set the starting ID
NUM=0

# set the last ID
LAST_NUM=10080

dir=$PWD/${COLLECTION}_metadata
mkdir -p $dir

while [ $NUM -le $LAST_NUM ]; do

# change these to fit your NFT
# put ${NUM} wherever you want the ID to appear
# put ${COLLECTION} wherever you want the collection name to appear
thumbFile="${COLLECTION}_${NUM}_thumbnail.png"
fullFile="${COLLECTION}_${NUM}.png"
description="${COLLECTION} #${NUM} - PUT DESCRIPTION HERE"
name="${COLLECTION} #${NUM}"

cat <<EOF > ${dir}/${COLLECTION}_${NUM}.json
{
  "name": "${name}"
  "description": "${description}",
  "image": "ipfs://${thumbCID}/${thumbFile}",
  "animation_url": "ipfs://${fullCID}/${fullFile}",
  "royalty_percentage": ${royalty},
  "attributes": [],
  "properties": {}
}
EOF
((NUM++))
done
