<div class="background">
    <form id="product_add" action='' method='POST' enctype="multipart/form-data">
        <div class="row">
            <?php if($this->session->flashdata('msg')){
                echo '<div class="col-md-6"><div class="alert alert-success">';
                echo $this->session->flashdata('msg');
                echo '</div></div>';
            } ?>
        </div>
        <div class="title">Add Story</div> 
        <hr>
        <div class="row">
            <div class="content-form">
                <div class="col-md-7">
                    <div class="col-md-12">
                        <label>Story Name</label>
                        <div class="form-group">
                            <input type="text" name='name' id="name" value="" class="form-control" required="" placeholder="Type Name"/>
                            <span class="mess_err" id="name_err"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Story Description</label>
                        <div class="form-group">
                            <textarea name="description" id='text-area-des' maxlength='475' class="form-control textarea" required="" rows="4" placeholder="Type Description"></textarea>
                            <span class="mess_err" id="des_err"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Genre</label>
                            <select id='genre_id' class="form-control" required name='genre_id[]' multiple="multiple">
                                <?php
                                foreach ($genres as $item) {
                                    echo "<option value='{$item['id']}'>{$item['name']}</option>";
                                }
                                ?>
                            </select>
                            <span class="mess_err" id="genre_err"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select id='status' class="form-control" required name='status'>
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="mess_err" id="status_err"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Creators</label>
                        <div class="form-group">
                            <input type="text" name='creators' id="creators" value="" class="form-control" required="" placeholder="Type Creator"/>
                            <span class="mess_err" id="creators_err"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Paywall Block</label>
                            <select id='paywall_episode' class="form-control" name='paywall_episode' disabled="disabled">
                                <option>Select Paywall Block</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Trailer JW Media ID</label>
                        <div class="form-group">
                            <input type="text" name='jw_media_id' id="jw_media_id" value="" class="form-control" required="" placeholder="Type JW Media ID" />
                            <span class="mess_err" id="jw_err"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div id="upload-img">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 portlets m-b-30">
                                    <label>Poster Image</label>
                                    <div class="row">
                                        <img id='poster_image' src="<?php echo base_url('assets/images/borders/233x346@3x.png')?>"/>
                                        <div class="mess_err" id="poster_err"></div>
                                        <div class="uploader" onclick="$('#posterImg').click()">
                                            <button type="button" class="btn ">Upload</button>
                                            <input type="file" accept="image/*" name="poster_img" id="posterImg" class="imagePhoto" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 portlets m-b-30">
                                    <label>Story Image</label>
                                    <div class="row">
                                        <img id='series_image' src="<?php echo base_url('assets/images/borders/750x667@3x.png')?>"/>
                                        <div class="mess_err" id="story_err"></div>
                                        <div class="uploader" onclick="$('#seriesImg').click()">
                                            <button type="button" class="btn ">Upload</button>
                                            <input type="file" accept="image/*" name="series_img" id="seriesImg" class="imagePhoto" required="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding-left: 0;padding-right: 0">
                                <div class="col-md-12 portlets m-b-30">
                                    <label>Carousel Banner</label>
                                    <div class="row">
                                        <img id='carousel_image' src="<?php echo base_url('assets/images/borders/667x440@3x.png')?>"/>
                                        <div class="mess_err" id="car_err"></div>
                                        <div class="uploader" onclick="$('#carouselImg').click()">
                                            <button type="button" class="btn ">Upload</button>
                                            <input type="file" accept="image/*" name="carousel_img" id="carouselImg" class="imagePhoto" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 portlets m-b-30">
                                    <label>Explore Preview Image</label>
                                    <div class="row">
                                        <img id='explore_image' src="<?php echo base_url('assets/images/borders/650x688@3x.png')?>"/>
                                        <div class="mess_err" id="ex_err"></div>
                                        <div class="uploader" onclick="$('#exploreImg').click()">
                                            <button type="button" class="btn ">Upload</button>
                                            <input type="file" accept="image/*" name="explore_img" id="exploreImg" class="imagePhoto"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="bottom">
                <div style='margin-top: 16px' class="col-md-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-update" value='Save' onclick="saveProduct('add')">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
