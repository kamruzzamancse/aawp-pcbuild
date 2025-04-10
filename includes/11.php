$request_payload = [
        'Keywords'     => $category,
        'SearchIndex'  => 'Electronics',
        'Resources'    => [
            'Images.Primary.Large',
            'ItemInfo.Title',
            'Offers.Listings.Price',
            'Offers.Listings.DeliveryInfo.IsFreeShippingEligible',
            'Offers.Listings.Promotions',
            'Offers.Listings.IsEligibleForPrime',
            'Offers.Listings.Availability.Message',
            'DetailPageURL'
        ],
        'PartnerTag'   => $associate_tag,
        'PartnerType'  => 'Associates',
        'Marketplace'  => 'www.amazon.com'
    ];












<!-- START: PC Builder Section -->
<section id="buildOverview">
        <!-- ====modal===== -->
        <div id="component_modal">
            
        </div>
        <!-- ===parts header==== -->
        <div class="partsHeader">
            <h3>Choose Your Parts</h3>
            <div class="navNtab">
                <ol>
                    <li>
                        <button class="tab-btn" onclick="openTab(event, 'tab1')">Chooose Component</button>
                    </li>
                    <li>
                        <button class="tab-btn active" onclick="openTab(event, 'tab2')">Overview</button>
                    </li>

                </ol>
            </div>
        </div>
        <div class="container">
            <!-- =========url section===== -->
            <div class="productControler">
                <div class="urlWarpper">
                    <div class="urlbox">
                        <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#FFFFFF">
                                <path
                                    d="M360-240q-33 0-56.5-23.5T280-320v-480q0-33 23.5-56.5T360-880h360q33 0 56.5 23.5T800-800v480q0 33-23.5 56.5T720-240H360Zm0-80h360v-480H360v480ZM200-80q-33 0-56.5-23.5T120-160v-560h80v560h440v80H200Zm160-240v-480 480Z" />
                            </svg></span>
                        <input type=" text" value="https://pcpartpicker.com/list/9nCdnp">
                    </div>
                    <div class="markUpbox">
                        <div class="markUpIcon">
                            <span>Markup :</span>
                            <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#FFFFFF">
                                    <path
                                        d="M80-600v-160q0-33 23.5-56.5T160-840h640q33 0 56.5 23.5T880-760v160h-80v-160H160v160H80Zm80 360q-33 0-56.5-23.5T80-320v-200h80v200h640v-200h80v200q0 33-23.5 56.5T800-240H160ZM40-120v-80h880v80H40Zm440-420ZM80-520v-80h240q11 0 21 6t15 16l47 93 123-215q5-9 14-14.5t20-5.5q11 0 21 5.5t15 16.5l49 98h235v80H620q-11 0-21-5.5T584-542l-26-53-123 215q-5 10-15 15t-21 5q-11 0-20.5-6T364-382l-69-138H80Z" />
                                </svg></span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#FFFFFF">
                                    <path
                                        d="M320-240 80-480l240-240 57 57-184 184 183 183-56 56Zm320 0-57-57 184-184-183-183 56-56 240 240-240 240Z" />
                                </svg>
                            </span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#FFFFFF">
                                    <path
                                        d="M160-280v80h640v-80H160Zm0-440h88q-5-9-6.5-19t-1.5-21q0-50 35-85t85-35q30 0 55.5 15.5T460-826l20 26 20-26q18-24 44-39t56-15q50 0 85 35t35 85q0 11-1.5 21t-6.5 19h88q33 0 56.5 23.5T880-640v440q0 33-23.5 56.5T800-120H160q-33 0-56.5-23.5T80-200v-440q0-33 23.5-56.5T160-720Zm0 320h640v-240H596l84 114-64 46-136-184-136 184-64-46 82-114H160v240Zm200-320q17 0 28.5-11.5T400-760q0-17-11.5-28.5T360-800q-17 0-28.5 11.5T320-760q0 17 11.5 28.5T360-720Zm240 0q17 0 28.5-11.5T640-760q0-17-11.5-28.5T600-800q-17 0-28.5 11.5T560-760q0 17 11.5 28.5T600-720Z" />
                                </svg>
                            </span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#FFFFFF">
                                    <path
                                        d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z" />
                                </svg>
                            </span>
                        </div>
                        <div class="markupBtn">
                            <div class="divASbtn">
                                <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                        width="24px" fill="#FFFFFF">
                                        <path
                                            d="M320-160q-33 0-56.5-23.5T240-240v-120h120v-90q-35-2-66.5-15.5T236-506v-44h-46L60-680q36-46 89-65t107-19q27 0 52.5 4t51.5 15v-55h480v520q0 50-35 85t-85 35H320Zm120-200h240v80q0 17 11.5 28.5T720-240q17 0 28.5-11.5T760-280v-440H440v24l240 240v56h-56L510-514l-8 8q-14 14-29.5 25T440-464v104ZM224-630h92v86q12 8 25 11t27 3q23 0 41.5-7t36.5-25l8-8-56-56q-29-29-65-43.5T256-684q-20 0-38 3t-36 9l42 42Zm376 350H320v40h286q-3-9-4.5-19t-1.5-21Zm-280 40v-40 40Z" />
                                    </svg></span>
                                <span>history</span>
                            </div>
                            <div class="divASbtn">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                        width="24px" fill="#FFFFFF">
                                        <path
                                            d="M840-680v480q0 33-23.5 56.5T760-120H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h480l160 160Zm-80 34L646-760H200v560h560v-446ZM480-240q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM240-560h360v-160H240v160Zm-40-86v446-560 114Z" />
                                    </svg>
                                </span>
                                <span>Save as</span>
                            </div>
                            <div class="divASbtn">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                        width="24px" fill="#FFFFFF">
                                        <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                                    </svg>
                                </span>
                                <span>Start new</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="CompitibleNotes">
                    <div class="greenSection">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#FFFFFF">
                                <path
                                    d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-139-35-229.5-159.5T160-516v-244l320-120 320 120v244q0 152-90.5 276.5T480-80Zm0-84q104-33 172-132t68-220v-189l-240-90-240 90v189q0 121 68 220t172 132Zm0-316Z" />
                            </svg>
                        </span>
                        <p>
                            <b> Compatibility:</b>
                            See <a href="#">notes</a> below.
                        </p>
                    </div>
                    <div class="skySection">
                        <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#FFFFFF">
                                <path
                                    d="m280-80 160-300-320-40 480-460h80L520-580l320 40L360-80h-80Zm222-247 161-154-269-34 63-117-160 154 268 33-63 118Zm-22-153Z" />
                            </svg></span>
                        <a href="#">Estimated Wattage:<b>120W</b> </a>
                    </div>
                </div>
            </div>
            <div class="tab_Content_Warpper">

                <!-- =====over view======= -->
                <div id="tab1" class="tab-content active">
                    Content for Tab 1
                    <div class="cardWarpper">
                        <!-- =======row heading===== -->
                        <div class="row">
                            <div class="comp card">
                                <span class="rowHeading">Component</span>
                            </div>
                            <div class="selection card">
                                <span class="rowHeading">Selection</span>
                            </div>
                            <div class="base card">
                                <span class="rowHeading">Base</span>
                            </div>
                            <div class="promo card">
                                <span class="rowHeading">Promo</span>
                            </div>
                            <div class="shiping card">
                                <span class="rowHeading">Shiping</span>
                            </div>
                            <div class="tax card">
                                <span class="rowHeading">Tax</span>
                            </div>
                            <div class="Availability card">
                                <span class="rowHeading">Availability</span>
                            </div>
                            <div class="price card">
                                <span class="rowHeading">Price</span>
                            </div>
                            <div class="where card">
                                <span class="rowHeading">Where</span>
                            </div>
                            <div class="buy card">
                                <!-- <span>buy</span> -->
                            </div>
                            <div class="cancel card">
                                <!-- <span>cancel</span> -->
                            </div>
                        </div>

                        <!-- =======cpu====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">CPU</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style="font-size:20px;">&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Chose a CPU</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======CPU Cooler====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">CPU Cooler</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style="font-size:20px;">&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A CPU Cooler</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Motherboard====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Motherboard</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style="font-size:20px;">&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Motherboard</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Memory====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Memory</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Memory</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Storage====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Storage</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Storage</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Video Card====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Video Card</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Video Card</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Case====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Case</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Case</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Power Supply====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Power Supply</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Power Supply</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Operating System====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Operating System</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Operating System</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Monitor====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Monitor</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Monitor</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>


                    </div>

                </div>
                <div id="tab2" class="tab-content">Content for Tab 2
                    <div class="cardContiner">
                        <div class="componentCard" id="CHASSIS" onclick="component_card_modal(event,id)">
                            <h3>CHASSIS</h3>
                            <h5>CHASSIS NAME</h5>
                            <div class="editBox">
                                <i class="fa-regular fa-circle-check"></i>
                                EDIT
                            </div>
                        </div>
                        <div class="componentCard" id="CPU" onclick="component_card_modal(event,id)">
                            <h3>CPU</h3>
                            <h5>CPU NAME</h5>
                            <div class="editBox">
                                <i class="fa-regular fa-circle-check"></i>
                                EDIT
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- END: PC Builder Section -->