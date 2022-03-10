#!/usr/bin/env bash

# change to the name of the NFT collection
COLLECTION="FryPhone"

# change this to the top-level CID for your image folder
CID="QmYfhkvAKiA93bMBhSSDhW28sAUuE5VdeUDyKxPAYqF1Xd"

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
filename="${COLLECTION}_${NUM}.png"
description="${COLLECTION} #${NUM} - FryPhones are 10,080 sentient phones to collect! @JoshFryArt on twitter - joshuaf.loopring.eth"
name="${COLLECTION} #${NUM}"

cat <<EOF > ${dir}/FryPhone_${NUM}.json
{
  "description": "${description}",
  "image": "ipfs://${CID}/${filename}",
  "name": "${name}"
}
EOF
((NUM++))
done
