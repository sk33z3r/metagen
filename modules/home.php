<?php
    if ($type === "head") { ?>
        <title>Puzzle Deliveries</title>
        <meta name="description" content="sk33z3r's puzzle delivery services">
<?php }
    if ($type === "body") { ?>
        <div class="content">
            <div id="guide">
                <div class="section">
                    <h2>MetaGen</h2>
                    <p>A simple metadata JSON generator for large NFT collections.</p>
                    <h4>How to use:</h4>
                    <ol>
                        <li>Put all of your images into a folder. The filenames should follow this scheme: <code>collection_00.png</code>.</li>
                        <li>Upload that <b>folder</b> to an IPFS service, such as <a href="https://nft.storage" target="_blank">https://nft.storage</a></li>
                        <li>Use the CID of that <b>folder</b> in this form.</li>
                        <li>This site will generate all the metadata files, zip them up for download.</li>
                        <li>Unzip the download, and upload the metadata <b>folder</b> to the IPFS service.</li>
                        <li>Copy the CID of each individual metadata file in IPFS to use in the Loopring Mint UI.</li>
                    </ol>
                </div>
                <div class="section">
                    <h4 id="example">Example JSON</h4>
<pre>{
  "name": "Collection #00",
  "description": "A string of text that describes the collection.",
  "image": "ipfs://Qme335fpuhbsgdYvjFPmQ5UqSdizNW4SjYDM7urZgm4XNA/collection_00.png"
}</pre>
                </div>
            </div>
            <form method="post" action="/">
                <input type="text" class="form wide" id="collection" name="collection" placeholder="Collection Name" />
                <input type="text" class="form wide" id="cid" name="cid" placeholder="Image Folder CID" />
                <input type="text" class="form wide" id="description" name="description" placeholder="Description" />
                <div id="files">
                    <input class="form small" type="number" min="0" max="9999" id="fid" name="fid" placeholder="First ID" />
                    <input class="form small" type="number" min="1" max="10000" id="lid" name="lid" placeholder="Last ID" />
                    <select class="form small" id="ext" name="ext">
                        <option value="png">png</option>
                        <option value="jpg">jpg</option>
                        <option value="jpeg">jpeg</option>
                        <option value="gif">gif</option>
                        <option value="tiff">tiff</option>
                        <option value="webp">webp</option>
                        <option value="svg">svg</option>
                    </select>
                </div>
                <input class="form btn" type="submit" name="submit" value="GENERATE" />
            </form>
        </div>
<?php include "modules/footer.html"; } ?>