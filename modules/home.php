<?php
    if ($type === "head") { ?>
        <title>MetaGen</title>
        <meta name="description" content="Large NFT collection metadata generator.">
<?php }
    if ($type === "body") { ?>
        <div class="content">
            <h2>MetaGen | A simple metadata JSON generator for large NFT collections.</h2>
            <?php if (empty($_POST['collection'])) { ?>
            <div id="guide">
                <div class="section">
                    <p>This is intended to generate hundreds or thousands of JSON files to guarantee the right syntax. If you choose to add dummy traits, you will need to edit each file individually after generated. A new version is coming soon that will allow you to specify your own traits in the form, but it is a complicated bit of logic.</p>
                    <p>Before you start, you <i><b>must</b></i> follow the proper folder and naming schemes for this generator to work for you. Please READ very carefully! (and send feet).</p>
                    <h3>Folder and Filename Structures</h3>
                    <p>The metadata expects your image files to be files within a folder on IPFS, so that the CID you paste here loads a list of files through a gateway. This script tacks on the filenames for you.</p>
                    <p>There are two CID fields: 1 for thumbnail images and 1 for the actual content. See the file-type drop downs for which file types are accepted. It is completely fine to paste the same CID for both fields if you only have 1 set of images!</p>
                    <p>The filenames should match the collection name, except lowercase and replacing any spaces with underscores. For instance, if your collection name is "My First NFT", then all of your files should be named <code>my_first_nft_XX.png</code>, where XX is an ID number.</p>
                    <p>Increment the ID numbers in your filenames, starting and ending at whatever number you want. Just make sure to enter the correct First and Last IDs in the fields below.</p>
                    <p>Upload the thumbnail and content folders to <a href="https://pinata.cloud" target="_blank">pinata.cloud</a> or using <a href="https://docs.ipfs.io/install/ipfs-desktop/" target="_blank">IPFS Desktop</a> to get your CIDs. Once generated, you'll get a zipped file of all the metadata files for upload to IPFS.</p>
                    <p><i>Disclaimer: You will still have to copy and paste each individual metadata CID if you plan to use the web minting UI.</i></p>
                </div>
            </div>
            <form method="post" action="/">
                <div id="artist" class="row">
                    <input required type="text" class="form med" id="collection" name="collection" placeholder="Collection Name" />
                    <input required type="text" class="form med" id="artist" name="artist" placeholder="Artist Name" />
                    <input required type="number" class="form med" min="0" max="50" id="royalty" name="royalty" placeholder="Royalty % (Max 50)" />
                </div>
                <!-- These two inputs have patterns that will match both pinata and nft.storage CIDs for when this is compatible with LRC systems. -->
                <!-- <input required type="text" class="form wide" pattern="(^Qm[1-9A-Za-z]{44}|^baf[a-z0-9]{56})" id="thumbCID" name="thumbCID" placeholder="Thumbnail Folder CID" /> -->
                <!-- <input required type="text" class="form wide" pattern="(^Qm[1-9A-Za-z]{44}|^baf[a-z0-9]{56})" id="contentCID" name="contentCID" placeholder="Content Folder CID" /> -->
                <input required type="text" class="form wide" pattern="^Qm[1-9A-Za-z]{44}" id="thumbCID" name="thumbCID" placeholder="Thumbnail Folder CID" />
                <input required type="text" class="form wide" pattern="^Qm[1-9A-Za-z]{44}" id="contentCID" name="contentCID" placeholder="Content Folder CID" />
                <input required type="text" class="form wide" id="description" name="description" placeholder="Description" />
                <div class="row">
                    <input required class="form small" type="number" min="0" max="9999" id="fid" name="fid" placeholder="First ID" />
                    <input required class="form small" type="number" min="1" max="10000" id="lid" name="lid" placeholder="Last ID" />
                    <label for="traits">Populate dummy traits?</label>
                    <input type="checkbox" id="traits" name="traits" value="true">
                </div>
                <div id="drops" class="row">
                    <span>File Type of Thumbnails:</span>
                    <select required class="form small" id="thumbExt" name="thumbExt">
                        <option value="png">png</option>
                        <option value="jpg">jpg</option>
                        <option value="jpeg">jpeg</option>
                        <option value="gif">gif</option>
                        <option value="tiff">tiff</option>
                        <option value="webp">webp</option>
                        <option value="svg">svg</option>
                    </select>
                    <span>File Type of Content:</span>
                    <select required class="form small" id="fullExt" name="fullExt">
                        <optgroup label="Images">
                            <option value="png">png</option>
                            <option value="jpg">jpg</option>
                            <option value="jpeg">jpeg</option>
                            <option value="gif">gif</option>
                            <option value="tiff">tiff</option>
                            <option value="webp">webp</option>
                            <option value="svg">svg</option>
                        </optgroup>
                        <optgroup label="Video">
                            <option value="mp4">mp4</option>
                            <option value="avi">avi</option>
                            <option value="webm">webm</option>
                        </optgroup>
                        <optgroup label="Audio">
                            <option value="mp3">mp3</option>
                            <option value="flac">flac</option>
                            <option value="ogg">ogg</option>
                        </optgroup>
                        <optgroup label="3D">
                            <option value="iges">iges</option>
                            <option value="sldprt">sldprt</option>
                        </optgroup>
                    </select>
                </div>
                <input class="form btn" type="submit" name="submit" value="GENERATE" />
            </form>
            <?php } else {
                $collection = $_POST['collection'];
                $artist = $_POST['artist'];
                $royalty = $_POST['royalty'];
                $thumbCID = $_POST['thumbCID'];
                $contentCID = $_POST['contentCID'];
                $description = $_POST['description'];
                $fid = $_POST['fid'];
                $lid = $_POST['lid'];
                $thumbExt = $_POST['thumbExt'];
                $fullExt = $_POST['fullExt'];
                if (!empty($_POST['traits'])) { $traits = $_POST['traits']; } else { $traits = false; }
                $col_file = str_replace(' ', '_', strtolower($collection));
                $path = "generated/${col_file}_metadata";
                if (!file_exists($path)) {
                    mkdir($path, 0770, true);
                }
                ?>
                <div class="section">
                    <h3>Hang tight, I'm generating all of your glorious metadata...</h3>
                    <div id="log">
                        <?php
                            $num = $fid;
                            while ($num <= $lid) {
                                $json_file = "${path}/${col_file}_${num}.json";
                                $thumb_file = "${col_file}_${num}.${thumbExt}";
                                $thumb_url = "ipfs://${thumbCID}/${thumb_file}";
                                $full_file = "${col_file}_${num}.${fullExt}";
                                $full_url = "ipfs://${contentCID}/${full_file}";
                                $name = "${collection} #${num}";

                                if ($traits !== "true") {
                                    $attributes = array(array("trait_type"=>"Artist", "value"=>$artist));
                                    $properties = array("Artist"=>$artist);
                                } else {
                                    $attributes = array(
                                                        array("trait_type"=>"Trait 01 Name", "value"=>"Trait 01 Value"),
                                                        array("trait_type"=>"Trait 02 Name", "value"=>"Trait 02 Value"),
                                                        array("trait_type"=>"Trait 03 Name", "value"=>"Trait 03 Value"),
                                                        array("trait_type"=>"Trait 04 Name", "value"=>"Trait 04 Value"),
                                                        array("trait_type"=>"Trait 05 Name", "value"=>"Trait 05 Value")
                                                    );
                                    $properties = array(
                                                        "Trait 01 Name"=>"Trait 01 Value",
                                                        "Trait 02 Name"=>"Trait 02 Value",
                                                        "Trait 03 Name"=>"Trait 03 Value",
                                                        "Trait 04 Name"=>"Trait 04 Value",
                                                        "Trait 05 Name"=>"Trait 05 Value"
                                                    );
                                }

                                $metadata = array("name"=>$name,
                                                "description"=>$description,
                                                "image"=>$thumb_url,
                                                "animation_url"=>$full_url,
                                                "royalty_percentage"=>(int)$royalty,
                                                "attributes"=>$attributes,
                                                "properties"=>$properties
                                                );

                                $json = json_encode($metadata, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
                                $bytes = file_put_contents($json_file, $json);
                                echo "<p>JSON written to ${json_file}. ${bytes}B total size.</p>";

                                $num++;
                            }
                            echo "<p>Zipping up the files...</p>";
                            $zip_file = "generated/${col_file}_metadata.zip";
                            $rootPath = realpath($path);

                            // Initialize archive object
                            $zip = new ZipArchive();
                            $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

                            // Create recursive directory iterator
                            /** @var SplFileInfo[] $files */
                            $files = new RecursiveIteratorIterator(
                                new RecursiveDirectoryIterator($rootPath),
                                RecursiveIteratorIterator::LEAVES_ONLY
                            );

                            foreach ($files as $name => $file)
                            {
                                // Skip directories (they would be added automatically)
                                if (!$file->isDir())
                                {
                                    // Get real and relative path for current file
                                    $filePath = $file->getRealPath();
                                    $relativePath = substr($filePath, strlen($rootPath) + 1);

                                    // Add current file to archive
                                    $zip->addFile($filePath, $relativePath);
                                }
                            }

                            // Zip archive will be created only after closing object
                            $zip->close();
                            echo "<p>...zip archive created!</p>";
                            shell_exec("rm -r $path");
                        ?>
                    </div>
                    <h3>...here's a big fat bag o' json for ya:</h3>
                    <a href="<?php echo "/${zip_file}"; ?>"><button class="form btn">Collection Download</button></a>
                    <p><small><i>PLEASE NOTE: This download link will expire in 1 hour.</i><small></p>
                    <a href="/"><button class="form btn">Go Back to Form</button></a>
                </div>
            <?php } ?>
        </div>
<?php include "modules/footer.html"; } ?>