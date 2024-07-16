<?php


class AdsCampaign{
	
	use GenericClass;
	
	/*** Class properties (member variables) ***/
	
	/* Variable for ads campaign store name */
	public static $storeName = 'Kranook Ads Campaign Store';
	
	/* Variable for global database manager */
	private $DBM;
	
	/* Variable for global session/account object (holds the current session user informations and other account methods) */
	private $SESS;
	private $ACCOUNT;
	
	/* Variable for global SITE object */
	private $SITE;
	
	/* Variable for global ENGINE object */
	private $ENGINE;
	
	/* Variable for global INT_HASHER object */
	private $INT_HASHER;
	
	/* Variable for global notLogged message */
	private $notLoggedMsg;
	
	/* Variable for global mediaRootBanner */
	private $mediaRootBanner;
	
	/* Variable for global mediaRootBannerXCL */
	private $mediaRootBannerXCL;
	
	/* Variable for global mediaRootFav */
	private $mediaRootFav;
	
	/* Variable for global pageSelf */
	private $pageSelf;
	
	/* Variable for global current page url encoded to be passed as a return url from other pages */
	private $rdr;
	
	/* Variable for global decoded return url gotten from the encoded version passed to other pages  */
	private $returnUrl;
	
	/* Variable for global siteName */
	private $siteName;
	
	/* Variable for global siteDomain */
	private $siteDomain;
	
	/* Variable for global FA_infoCircle */
	private $FA_infoCircle;
	
	/* Variable for global FA_shield */
	private $FA_shield;
	
	/* Variable for global FA_times */
	private $FA_times;
	
	/* Variable for global delIcon */
	private $delIcon;
	
	/* Ads campaign type(defaults to banner campaign type) */
	private $campaignType;
	
	/* Banner campaign type */
	private static $bannerCampaignType = 'banner';
	
	/* Text campaign type */
	private static $textCampaignType = 'text';
	
	/* Banner campaign database table name  */
	private static $bannerCampaignTable;
	
	/* Text campaign database table name  */
	private static $textCampaignTable;
	
	/* campaign ad types */
	private static $campaignAdType1 = 'banner_1';
	private static $campaignAdType2 = 'banner_2';
	private static $campaignAdType3 = 'banner_3';
	private static $campaignAdType4 = 'text_1';
	private static $bannerAdTypesCommaList;
	private static $textAdTypesCommaList;
	
	/* campaign ad types slots */
	private static $campaignAdType1Slots = AD_TYPE1_SLOTS;
	private static $campaignAdType2Slots = AD_TYPE2_SLOTS;
	private static $campaignAdType3Slots = AD_TYPE3_SLOTS;
	private static $campaignAdType4Slots = AD_TYPE4_SLOTS;
	
	/* banner dimension details (array) */
	private static $bannerDimensionDetails;
	
	/* designated approved ad state */
	private static $approvedAdState = 1;
	
	/* designated pending ad state */
	private static $pendingAdState = 2;
	
	/* designated disapproved ad state */
	private static $disapprovedAdState = 3;
	
	/* SLUGS */
	//Edit
	private static $editBaseSlug = 'edit-ad';			
	private static $bannerEditSlug = 'banner';
	private static $textEditSlug = 'text-info';
	private static $landPageEditSlug = 'landing';

	//Upload
	private static $uploadBaseSlug = 'upload-ad';
	private static $bannerUploadSlug = 'banner';
	private static $textUploadSlug = 'text-info';
	
	
	/*** Public class methods (functions) ***/
	
	
	
	/* Constructor */
	public function __construct($campaignType=null){
		
		global $dbm, $ACCOUNT, $ENGINE, $SITE, $INT_HASHER, $GLOBAL_notLogged, $GLOBAL_mediaRootBanner,
		$GLOBAL_mediaRootBannerXCL, $GLOBAL_mediaRootFav, $GLOBAL_page_self, $GLOBAL_rdr, $rdrAlt, $GLOBAL_siteDomain, $GLOBAL_siteName,
		$FA_infoCircle, $FA_shield, $FA_times, $GLOBAL_delBtn;
		
		$this->campaignType = $campaignType? strtolower($campaignType) : self::$bannerCampaignType;
		self::$bannerCampaignTable = self::$bannerCampaignType.'_campaigns';
		self::$textCampaignTable = self::$textCampaignType.'_campaigns';
		$this->DBM = $dbm;
		$this->SESS = $ACCOUNT->SESS;
		$this->ACCOUNT = $ACCOUNT;
		$this->ENGINE = $ENGINE;
		$this->SITE = $SITE;
		$this->INT_HASHER = $INT_HASHER;
		$this->notLoggedMsg = $GLOBAL_notLogged;
		$this->mediaRootBanner = $GLOBAL_mediaRootBanner;
		$this->mediaRootBannerXCL = $GLOBAL_mediaRootBannerXCL;
		$this->mediaRootFav = $GLOBAL_mediaRootFav;
		$this->pageSelf = $GLOBAL_page_self;
		$this->rdr = $GLOBAL_rdr;
		$this->returnUrl = $rdrAlt;
		$this->siteName = $GLOBAL_siteName;
		$this->siteDomain = $GLOBAL_siteDomain;
		$this->FA_infoCircle = $FA_infoCircle;
		$this->FA_shield = $FA_shield;
		$this->FA_times = $FA_times;
		$this->delIcon = $GLOBAL_delBtn;
		self::$bannerAdTypesCommaList = '"'.self::$campaignAdType1.'","'.self::$campaignAdType2.'","'.self::$campaignAdType3.'"';
		self::$textAdTypesCommaList = '"'.self::$campaignAdType4.'"';
		self::$bannerDimensionDetails = array(
			self::$campaignAdType1 => array('dimension' => BANNER_1_DIMENSION, 'size' => BANNER_1_S, 'height' => BANNER_1_H, 'width' => BANNER_1_W, 'campaignAdType' => $this->getCampaignAdType1()),
			self::$campaignAdType2 => array('dimension' => BANNER_2_DIMENSION, 'size' => BANNER_2_S, 'height' => BANNER_2_H, 'width' => BANNER_2_W, 'campaignAdType' => $this->getCampaignAdType2()),
			self::$campaignAdType3 => array('dimension' => BANNER_3_DIMENSION, 'size' => BANNER_3_S, 'height' => BANNER_3_H, 'width' => BANNER_3_W, 'campaignAdType' => $this->getCampaignAdType3())
		);
		
	}
	
	
	
	/* Destructor */
	public function __destruct(){
		
	}
	
	
	
	/*** Setters ***/
	
	/* Setter method for setting $campaignType */
	public function setCampaignType($campaignType){
		
		$campaignType? ($this->campaignType = strtolower($campaignType)) : '';
		
	}
	
	
	
	/*** Getters ***/
	
	/* Getter method for fetching $returnUrl */
	public function getReturnUrl(){
		
		return $this->returnUrl;
		
	}
	
	/* Getter method for fetching $bannerCampaignType */
	public function getBannerCampaignType(){
		
		return self::$bannerCampaignType;
		
	}
	
	/* Getter method for fetching $textCampaignType */
	public function getTextCampaignType(){
		
		return self::$textCampaignType;
		
	}
	
	/* Getter method for fetching $campaignType */
	public function getCampaignType(){
		
		return $this->campaignType;
		
	}
	
	/* Getter method for fetching all campaign types as an array */
	public function getCampaignTypes(){
		
		return array(self::$bannerCampaignType, self::$textCampaignType);
		
	}
	
	/* Getter method for fetching banner campaign database table name */
	public function getBannerCampaignTable(){
		
		return self::$bannerCampaignTable;
		
	}
	
	/* Getter method for fetching text campaign database table name */
	public function getTextCampaignTable(){
		
		return self::$textCampaignTable;
		
	}
	
	/* Getter method for fetching campaign database table name */
	public function getCampaignTable(){
		
		return ($this->getCampaignType().'_campaigns');
		
	}
	
	
	/* Getter method for fetching banner details */
	public function getBannerDetails($bannerType, $getIndex="dimension"){
		
		return (self::$bannerDimensionDetails[$bannerType][$getIndex]);
		
	}
	
	
	/* Getter method for fetching specifically banner type 1 details */
	public function getBanner1Details(){
		
		return (self::$bannerDimensionDetails[self::$campaignAdType1]);
		
	}
	
	/* Getter method for fetching specifically banner type 2 details */
	public function getBanner2Details(){
		
		return (self::$bannerDimensionDetails[self::$campaignAdType2]);
		
	}
	
	/* Getter method for fetching specifically banner type 3 details */
	public function getBanner3Details(){
		
		return (self::$bannerDimensionDetails[self::$campaignAdType3]);
		
	}
	
	
	
	/* Getter method for fetching campaign ad type 1 */
	public function getCampaignAdType1(){
		
		return (self::$campaignAdType1);
		
	}
	
	/* Getter method for fetching campaign ad type 2 */
	public function getCampaignAdType2(){
		
		return (self::$campaignAdType2);
		
	}
	
	/* Getter method for fetching campaign ad type 3 */
	public function getCampaignAdType3(){
		
		return (self::$campaignAdType3);
		
	}
	
	/* Getter method for fetching campaign ad type 4 */
	public function getCampaignAdType4(){
		
		return (self::$campaignAdType4);
		
	}
	
	/* Getter method for fetching campaign ad type 1 allocated slots */
	public function getCampaignAdType1Slots(){
		
		return (self::$campaignAdType1Slots);
		
	}
	
	/* Getter method for fetching campaign ad type 2 allocated slots */
	public function getCampaignAdType2Slots(){
		
		return (self::$campaignAdType2Slots);
		
	}
	
	/* Getter method for fetching campaign ad type 3 allocated slots */
	public function getCampaignAdType3Slots(){
		
		return (self::$campaignAdType3Slots);
		
	}
	
	/* Getter method for fetching campaign ad type 4 allocated slots */
	public function getCampaignAdType4Slots(){
		
		return (self::$campaignAdType4Slots);
		
	}
	
	
	/* Getter method for fetching banner ad types as comma separated list */
	public function getBannerAdTypesCommaList(){
		
		return (self::$bannerAdTypesCommaList);
		
	}
	
	/* Getter method for fetching text ad types as comma separated list */
	public function getTextAdTypesCommaList(){
		
		return (self::$textAdTypesCommaList);
		
	}
	
	/* Getter method for fetching campaign ad types details as an array */
	public function getCampaignAdTypesDetails(){
		
		return array(
			array('adType' => self::$campaignAdType1, 'slots' => self::$campaignAdType1Slots, 'campaignType' => self::$bannerCampaignType, 'campaignTable' => self::$bannerCampaignTable, 'widgetClass' => self::$campaignAdType1.($K=' widget banner-widget'), 'placeholderImg' => 'default-banner-'.str_replace(' ', '', $this->getBanner1Details()["dimension"]).'.gif'), 
			array('adType' => self::$campaignAdType2, 'slots' => self::$campaignAdType2Slots, 'campaignType' => self::$bannerCampaignType, 'campaignTable' => self::$bannerCampaignTable, 'widgetClass' => self::$campaignAdType2.' side-widget'.$K, 'placeholderImg' => 'default-banner-'.str_replace(' ', '', $this->getBanner2Details()["dimension"]).'.gif'), 
			array('adType' => self::$campaignAdType3, 'slots' => self::$campaignAdType3Slots, 'campaignType' => self::$bannerCampaignType, 'campaignTable' => self::$bannerCampaignTable, 'widgetClass' => self::$campaignAdType3.' side-widget'.$K, 'placeholderImg' => 'default-banner-'.str_replace(' ', '', $this->getBanner3Details()["dimension"]).'.gif'), 
			array('adType' => self::$campaignAdType4, 'slots' => self::$campaignAdType4Slots, 'campaignType' => self::$textCampaignType, 'campaignTable' => self::$textCampaignTable, 'widgetClass' => '', 'placeholderImg' => '') 
		
		);
		
	}
	
	
	/* Method for fetching approved ad state */
	public function getApprovedAdState(){
		
		return self::$approvedAdState;
		
	}
	
	/* Method for fetching disapproved ad state */
	public function getDisapprovedAdState(){
		
		return self::$disapprovedAdState;
		
	}
	
	/* Method for fetching pending approval ad state */
	public function getPendingAdState(){
		
		return self::$pendingAdState;
		
	}
	
	
	
	/* Method for fetching ad premium eligibility subQry */
	public function getPremiumEligSubQry($amount, $isIncrement){
		
		$computedPremiumPurseAmount = ((AD_PREMIUM_PURSE_TOPUP_RATE / 100) * $amount);
		
		$premiumAmtSubQry = ', ADS_PREMIUM_PURSE = (ADS_PREMIUM_PURSE '.($isIncrement? ' + ' : ' - ').(($amount >= AD_PREMIUM_ELIGIBILITY_AMOUNT)?  $computedPremiumPurseAmount  : 0).')';
												
		return $premiumAmtSubQry;
		
	}
	
	
	
	
	
	
	
	/* Method for validating campaign type passed by a client */
	public function validateCampaignType($campaign): bool {
		
		return in_array(strtolower($campaign), array($this->getBannerCampaignType(), $this->getTextCampaignType()));
		
	}
	
	
	/* Method for checking if $campaignType is banner */
	public function isBannerCampaign(): bool {
		
		return ($this->campaignType == self::$bannerCampaignType);
		
	}
	
	
	
	
	/* Method for checking if $campaignType is text */
	public function isTextCampaign(): bool {
		
		return ($this->campaignType == self::$textCampaignType);
		
	}
	
	
	
	
	/* Method for fetching autoInstantApproval button for ads uploads/edit */
	public function getAutoInstantApprovalBtn($retArr=false){
		
		$isTopStaff = $this->SESS->getUltimateLevel();
		$autoInstantApprovalCheckBoxStatus = ((!isset($_POST[$K="auto_instant_approval"]) && isset($_POST[$K."_submitted"])) || !$isTopStaff)? '' : 'checked="checked"';
		$field = ($isTopStaff? '<div class="field-ctrl">'.$this->SITE->getHtmlComponent('switch-slider', array('label'=>'Auto Instant Approval:', 'wrapClass'=>'text-warning', 'fieldName'=>$K, 'on'=>$autoInstantApprovalCheckBoxStatus)).'</div>' : '');
		
		return ($retArr? array($field, $autoInstantApprovalCheckBoxStatus) : $field);
		
	}

	
	
	
	
	/* Method for validating campaign landing page */
	public function landingPageValidated($landingPage){
		
		return (preg_match("#('http://'|'https://')?.+\..{1,}$#i", $landingPage)
				&& mb_strlen($landingPage) <= $this->getMeta("static")["maxLandPage"]);
		
	}
	
	
	
	
	/* Method for counting number of users campaign */
	public function countCampaign($userId, $cnd=''){
		
		if($userId){
		
			$table = $this->isBannerCampaign()? 'banner_campaigns' : 'text_campaigns';
			/////PDO QUERY//////////	
			$sql = 'SELECT COUNT(*) FROM '.$table.' WHERE USER_ID = ? '.$cnd;
			$valArr = array($userId);
			return $this->DBM->doSecuredQuery($sql, $valArr)->fetchColumn();

		}
		
		return 0;	
		
	}
	
	
	
	
	
	
	
	/* Method for populating banner dimension select menu */
	public function populateBannerDimensionSelectMenu($retArr=false){
		
		$bannerDimensionSelectOptions = '';
	
		$bannerDimensionPassed = isset($_POST[$K="banner_dimension"])? $this->ENGINE->sanitize_user_input($_POST[$K]) : '';
		$bannerDimensionArr = array($this->getBanner1Details()["dimension"], $this->getBanner2Details()["dimension"], $this->getBanner3Details()["dimension"]);
		
		foreach($bannerDimensionArr as $bannerDimension){
			
			$bannerDimensionSelectOptions .= '<option '.(($bannerDimension == $bannerDimensionPassed)? 'selected' : '').'>'.$bannerDimension.'</option>';
			
		}
		
		$field = '<select name="'.$K.'" class="field">'.$bannerDimensionSelectOptions.'</select>';
		
		return ($retArr? array($field, $bannerDimensionPassed) :  $field);
		
	}
	
	
	
	
	
	
	/* Method for fetching campaign meta datas */
	public function getMeta($metaType = '', $metaArr = array()){
		
		$adIdEnc = $this->ENGINE->get_assoc_arr($metaArr, 'adId');
		$refTitlePassed = $this->ENGINE->get_assoc_arr($metaArr, 'refTitle');
		$caseType = strtolower($this->ENGINE->get_assoc_arr($metaArr, 'type'));

		$kb2Byte = ONE_KB_BYTE;
		$bannerExtFmt = BANNER_EXT_FMT;
		$maxTextAdLink = MAX_TXT_AD_CONTENT;
		$maxLandPage = MAX_LANDPAGE;
		$metaType = strtolower($metaType);

		$trafficExpLinkCase = 'traffic_export_link'; 
		$billingExpLinkCase = 'billing_export_link';
		$bothExpLinkCase = 'both_export_link';

		switch($metaType){
			
			case 'upload_slug':				
				$slash = '/';
				$uploadBaseSlug = self::$uploadBaseSlug.$slash;

				switch($caseType){

					case 'banner': 
						$meta = $uploadBaseSlug.self::$bannerUploadSlug;
						break;
					
					default: //text
						$meta = $uploadBaseSlug.self::$textUploadSlug;

				}						
				break;
			
			case 'edit_slug':				
				$slash = '/';
				$editBaseSlug = self::$editBaseSlug.$slash;

				switch($caseType){

					case 'banner': 
						$meta = $editBaseSlug.$adIdEnc.$slash.self::$bannerEditSlug;
						break;

					case 'banner-lp': 
						$meta = $editBaseSlug.$adIdEnc.$slash.self::$landPageEditSlug;
						break;
					
					default: //text
						$meta = $editBaseSlug.$adIdEnc.$slash.self::$textEditSlug;

				}						
				break;

			case 'credit_purchase_btn':			
				$meta = PaymentGateway::getPaymentBtns(array('uid' => $this->SESS->getUserId()));			
				break;
			
			case 'static': $meta = array(
				
				'adMatrix' => AD_MATRIX, 'adMatrixScale' => MAX_AD_MATRIX, 'kb2Byte' => $kb2Byte, 'bannerExtFmt' => $bannerExtFmt, 'bannerExtArr' => BANNER_EXT_ARR, 
				'currencySymbol' => CURRENCY_SYMBOL, 'currency' => CURRENCY_SUFFIX, 'adCreditSuffix' => AD_CREDIT_SUFFIX, 'minAdDeposit' => MIN_AD_DEPOSIT, 'minAdPlaceCredit' => MIN_AD_PLACEMENT_CREDIT, 
				'bankDetails' => BANK_DETAILS, 'intlPayMeansUrl' => INTL_MEANS_OF_PAY_URL, 'campaignEvidEmail' => CAMPAIGN_EVID_EMAIL_ADDR, 'maxTextAdLink' => $maxTextAdLink, 'adBillBaseFreq' => AD_BILL_BASE_FREQ,
				'adRateBaseFreq' => AD_RATE_BASE_FREQ, 'premiumEligibilityAmount' => AD_PREMIUM_ELIGIBILITY_AMOUNT, 'fallBackDiscount' => FALLBACK_DISCOUNT, 'oneDaySecs' => ONE_DAY_SEC, 'maxLandPage' => $maxLandPage, 
				'banner2Charge' => BANNER_TYPE2_CHARGE, 'banner3Charge' => BANNER_TYPE3_CHARGE, 'textAdCharge' => TEXT_AD_CHARGE, 'textAdDiscountCharge' => TEXT_AD_DISCOUNT_CHARGE,
				'bannerEditSlug' => self::$bannerEditSlug, 'textEditSlug' => self::$textEditSlug, 'landPageEditSlug' => self::$landPageEditSlug
				
				); 
				break;
			
			case 'adbanner_upload_tip': 
				$banner1Details = $this->getBanner1Details();
				$banner2Details = $this->getBanner2Details();
				$banner3Details = $this->getBanner3Details();
				$meta = '<span class="red small">(please ensure that your banner conforms with the following requirements:<br/><span class="prime">Max-size: '.($banner1Details["size"] / $kb2Byte).'kb(for '.$banner1Details["dimension"].'), '.($banner2Details["size"] / $kb2Byte).'kb(for '.$banner2Details["dimension"].'), '.($banner3Details["size"] / $kb2Byte).'kb(for '.$banner3Details["dimension"].'), '.$bannerExtFmt.'</span>)</span>'; 
				break;
			
			case 'linktext_upload_tip': $meta = '<span class="small prime">(Description Text that will be shown on the link. It must not be more than '.$maxTextAdLink.' characters including spaces)</span>'; 
				break;
			
			case 'landpage_error_tip': $meta = '<span class="alert alert-danger">
													The landing page link you entered for your Ad is not a valid url<br/>
													Please observe the following:<br/>Limit to a maximum of '.$maxLandPage.' characters<br/>Check for spaces <br/>Make sure you have added the domain type extension(for example: .com, .net, .org, and so on) and try again
												</span>'; 
				break;
			
			case $trafficExpLinkCase: 
			case $billingExpLinkCase: 
			case $bothExpLinkCase: 
				$campaignType = $this->getCampaignType();
				$exportIcon = $this->SITE->getFA('fa-level-up-alt', array('title'=>'Export'));				
				$specQstr = $this->ENGINE->get_assoc_arr($metaArr, 'specQstr');
				$refTitle = 'your';
				$refTitlePassed? ($refTitle = str_ireplace($refTitle, $refTitlePassed, $refTitle)) : '';				
				$linkSep = ' | ';
				$exportBaseUrl = '/export-ads-campaign-datas/'.$campaignType;
				$trafficTitle = 'export '.$refTitle.' '.$campaignType.' campaign traffic data'.($adIdEnc? ' for ad: '.$adIdEnc : '');
				$trafficTitleExpd = str_ireplace('export '.$refTitle, 'export expanded version of '.$refTitle, $trafficTitle);				
				
				$trafficExportLink = ' <a href="'.(($K=$exportBaseUrl.'/traffic'.($adIdEnc? '/'.$adIdEnc : '')).$specQstr).'" class="links" title="'.$trafficTitle.'">Export Traffic Data'.$exportIcon.'</a>
							'.($this->SESS->getAdPremiumPurse()? '(<a href="'.$K.$this->ENGINE->merge_qstr(array($specQstr, 'export_type=expanded')).'" class="links" title="'.$trafficTitleExpd.'">Export Expanded'.$exportIcon.'</a>)' : '');				

				$billingExportLink = '<a href="'.$exportBaseUrl.'/billing/'.$adIdEnc.$specQstr.'" class="links"  title="export '.$refTitle.' '.$campaignType.' campaign billing data '.($adIdEnc? ' for ad: '.$adIdEnc : '').'">Export Billing Data'.$exportIcon.'</a>';
				
				$meta = (	($metaType == $trafficExpLinkCase)? $trafficExportLink : 
							(($metaType == $bothExpLinkCase)? $trafficExportLink.$linkSep.$billingExportLink : $billingExportLink)
						);
				
				break;

				
												
			//landpage_upload_tip									
			default: $meta = '<span class="small prime">(website or webpage where you want potential customers to be sent when they click the Ad Banner)</span>';
			
		}
		
		return $meta;
		
	}
	
	
	
	
	
	
	
	
	


	/* Method for filtering section ad rates */
	public function filterSectionRates($section){
		
		//return (preg_replace("#(.+)\((.*)\)#isU", "$1", $section));
		$adRatePart = strrchr($section, "(");
		//return (rtrim(str_ireplace($adRatePart, "", $section)));	
		return (rtrim(substr($section, 0, - strlen($adRatePart))));	
		
	}







	
	/* Method for fetching section ad slots available/used */
	public function getAdSlots($sid, $head=" THIS PAGE ", $countAll=false, $retType=''){
		
		$adSlots="";
		
		if($countAll){
			
			$sql = "SELECT COUNT(*) FROM active_section_ads WHERE ACTIVE_TIME != 0";
			$valArr = array();
			return $this->DBM->doSecuredQuery($sql, $valArr)->fetchColumn();
			
		}
		
		$qry = "(SELECT COUNT(*) FROM active_section_ads WHERE (SECTION_ID=? AND AD_TYPE=? AND ACTIVE_TIME != 0))";
		$sql = "SELECT ".$qry." AS TYPE1_SLOTS_FILLED,".$qry." AS TYPE2_SLOTS_FILLED,".$qry." AS TYPE3_SLOTS_FILLED,".$qry." AS TYPE4_SLOTS_FILLED";

		$valArr = array($sid, $this->getCampaignAdType1(), $sid, $this->getCampaignAdType2(), $sid, $this->getCampaignAdType3(), $sid, $this->getCampaignAdType4());
		$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
		$row = $this->DBM->fetchRow($stmt);

		if(!empty($row)){
							
			$t1SlotsFilled = $row["TYPE1_SLOTS_FILLED"];
			$t2SlotsFilled = $row["TYPE2_SLOTS_FILLED"];
			$t3SlotsFilled = $row["TYPE3_SLOTS_FILLED"];
			$t4SlotsFilled = $row["TYPE4_SLOTS_FILLED"];
			$adTypeSlotsArr = $this->getCampaignAdTypesDetails();
			
			$panelStyleArr = array('panel-orange', 'panel-gold', 'panel-gray', 'panel-limex');
			$headerArr = array($this->getBanner1Details()[$K="dimension"], $this->getBanner2Details()[$K], $this->getBanner3Details()[$K], ucwords($this->getTextCampaignType()));
			$slotsFilledArr = array($t1SlotsFilled, $t2SlotsFilled, $t3SlotsFilled, $t4SlotsFilled);
			$slotCapacityArr = array($adTypeSlotsArr[0]["slots"], $adTypeSlotsArr[1]["slots"], $adTypeSlotsArr[2]["slots"], $adTypeSlotsArr[3]["slots"]);
			
			for($i=0; $i < count($headerArr); $i++){
							
				$adSlots .= '<div class="base-mpad">
								<div class="panel '.$panelStyleArr[$i].' hover-elevationX">
									<h3 class="panel-head page-title">'.$headerArr[$i].' Ad Slots</h3>
									<ul class="panel-body hr-dividers">
										<li class="black">Total Slots: <b>'.($slotCapacity = $slotCapacityArr[$i]).'</b></li>
										<li class="green">Available: <b>'.($availSlots = ($slotCapacityArr[$i] - $slotsFilledArr[$i])).'</b></li>
										<li class="red">Occupied: <b>'.($filledSlots = $slotsFilledArr[$i]).'</b></li> 
									</ul>
								</div>
							</div>';
							
				$occupiedArr[] = $filledSlots;
				$availableArr[] = $filledSlots;
				$totalArr[] = $slotCapacity;
			}
				
			switch(strtolower($retType)){
				
				case 'occupied': $return = $occupiedArr; break;
				
				case 'available': $return = $availableArr; break;
				
				case 'total': $return = $totalArr; break;
				
			}
			
			if($retType)
				return $return;
			
			$adSlots = '<button class="btn btn-xs btn-success" data-toggle="smartToggler" data-toggle-attr="text|Hide Ad Slots" title="View Available and Used Ad Slots of '.strtolower($head).'">View Ad Slots</button>
						<div class="col-lg-w-8 center-block hide panel align-c">
							<h2 class="panel-head page-title">AD SLOTS FOR '.strtoupper($head).'</h2>
							<div class="equal-base section-adslots panel-body">'.$adSlots.'</div>
						</div>';
		}
		
		
		return $adSlots;

	} 









	/* Method for fetching section ad rates */
	public function getAdRate($metaArr){
		 
		$ret=$oldAdRateFmt=$oldAdRateFmt2=$premiumRateFmt=$premiumRateFmt2="";
		
		$sid = $this->ENGINE->get_assoc_arr($metaArr, 'sid');
		$type = $this->ENGINE->is_assoc_key_set($metaArr, $K='type')? $this->ENGINE->get_assoc_arr($metaArr, $K) : 'all';
		$appendToAll = $this->ENGINE->get_assoc_arr($metaArr, 'appendToAll');
		$forOption = $this->ENGINE->get_assoc_arr($metaArr, 'forOption');
		$forTextCampaign = $this->ENGINE->get_assoc_arr($metaArr, 'forTextCampaign');
		$bannerType = $this->ENGINE->get_assoc_arr($metaArr, 'bannerType');
		$forTable = $this->ENGINE->get_assoc_arr($metaArr, 'forTable');
		$noHeader = $this->ENGINE->get_assoc_arr($metaArr, 'noHeader');
		$banner1Dimension = $this->getBanner1Details()[$K="dimension"]; 
		$banner2Dimension = $this->getBanner2Details()[$K]; 
		$banner3Dimension = $this->getBanner3Details()[$K];
		$campaignMetas = $this->getMeta("static");
		
		$sql = "SELECT MIN_AD_RATE, CORRELATED_AD_RATE, CORRELATED_OLD_AD_RATE, MIN_DISCOUNT_RATE, CORRELATED_DISCOUNT_RATE, DISCOUNT_IS_PREMIUM, MIN_PREMIUM_RATE, CORRELATED_PREMIUM_RATE, ON_PREMIUM_RATE FROM sections WHERE ID=? LIMIT 1";

		$valArr = array($sid);
		$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
		$row = $this->DBM->fetchRow($stmt);
		
		if(!empty($row)){
			
			$bannerT2Charge = (BANNER_TYPE2_CHARGE / 100);
			$bannerT3Charge = (BANNER_TYPE3_CHARGE / 100);
			$textAdCharge = (TEXT_AD_CHARGE / 100);
			$textAdDiscountCharge = (TEXT_AD_DISCOUNT_CHARGE / 100);
			$minAdRate = $row["MIN_AD_RATE"];
			$banner1AdRate = $row["CORRELATED_AD_RATE"];
			$banner2AdRate = ($banner1AdRate + ($bannerT2Charge * $banner1AdRate));
			$banner3AdRate = ($banner1AdRate + ($bannerT3Charge * $banner1AdRate));
			$textAdRate = $banner1AdRate? ($banner1AdRate - ($textAdCharge * $banner1AdRate)) : 0;
			
			$banner1OldAdRate = $row["CORRELATED_OLD_AD_RATE"];
			$banner2OldAdRate = ($banner1OldAdRate + ($bannerT2Charge * $banner1OldAdRate));
			$banner3OldAdRate = ($banner1OldAdRate + ($bannerT3Charge * $banner1OldAdRate));
			$textAdOldRate = $banner1OldAdRate? ($banner1OldAdRate - ($textAdCharge * $banner1OldAdRate)) : 0;
			
			$minDiscountRate = $row["MIN_DISCOUNT_RATE"];
			$banner1DiscountRate = $row["CORRELATED_DISCOUNT_RATE"];
			$banner2DiscountRate = ($banner1DiscountRate - ($bannerT2Charge * $banner1DiscountRate));
			$banner3DiscountRate = ($banner1DiscountRate - ($bannerT3Charge * $banner1DiscountRate));
			$textDiscountRate = $banner1DiscountRate? ($banner1DiscountRate + ($textAdDiscountCharge * abs(100 - $banner1DiscountRate))) : 0;
			
			$onPremiumRate = $row["ON_PREMIUM_RATE"];
			$discountIsPremium = $row["DISCOUNT_IS_PREMIUM"];
			$minPremiumRate = $row["MIN_PREMIUM_RATE"];
			$banner1PremiumRate = $row["CORRELATED_PREMIUM_RATE"];
			$banner2PremiumRate = ($banner1PremiumRate + ($bannerT2Charge * $banner1PremiumRate));
			$banner3PremiumRate = ($banner1PremiumRate + ($bannerT3Charge * $banner1PremiumRate));
			$textPremiumRate = $banner1PremiumRate? ($banner1PremiumRate - ($textAdCharge * $banner1PremiumRate)) : 0;
			
			$allRatesArr = array("b1AdRate"=>$banner1AdRate,"b2AdRate"=>$banner2AdRate,"b3AdRate"=>$banner3AdRate,"textAdRate"=>$textAdRate,
								"b1OldAdRate"=>$banner1OldAdRate,"b2OldAdRate"=>$banner2OldAdRate,"b3OldAdRate"=>$banner3OldAdRate,"textOldAdRate"=>$textAdOldRate,
								"b1DiscountRate"=>$banner1DiscountRate,"b2DiscountRate"=>$banner2DiscountRate,"b3DiscountRate"=>$banner3DiscountRate,"textDiscountRate"=>$textDiscountRate,
								"b1PremiumRate"=>$banner1PremiumRate,"b2PremiumRate"=>$banner2PremiumRate,"b3PremiumRate"=>$banner3PremiumRate,"textPremiumRate"=>$textPremiumRate,
								"minAdRate"=>$minAdRate,"minDiscountRate"=>$minDiscountRate,"minPremiumRate"=>$minPremiumRate,"discountIsPremium"=>$discountIsPremium,"onPremiumRate"=>$onPremiumRate
							);
							
							
		}
		
		$oldRateAcc=$adRateAcc=$premiumRateAcc=$discountRateAcc=array();
		
		$adTypesArr = $this->getCampaignAdTypesDetails();
		$textAdType = $this->getCampaignAdType4();
		$i = 1;
		
		foreach($adTypesArr as $adTypeArr){
			
			$adType = $adTypeArr["adType"];
			
			if(($bannerType && $adType != $bannerType) || ($forTextCampaign && $adType != $textAdType)){
				
				$i++;;
				continue;
				
			}
			
			switch($adType){
				
				case $textAdType: $oldRateKey = 'textOldAdRate'; 
					$adRateKey = 'textAdRate'; 
					$premiumRateKey = 'textPremiumRate'; 
					$discountRateKey = 'textDiscountRate'; 
					break;	
				
				default: $oldRateKey = 'b'.$i.'OldAdRate'; 
					$adRateKey = 'b'.$i.'AdRate'; 
					$premiumRateKey = 'b'.$i.'PremiumRate'; 
					$discountRateKey = 'b'.$i.'DiscountRate';
				
			}
			
			$oldRateAcc[$i] = ($forOption? '' : '<b><del class="strike">').($currencySymbol = $campaignMetas["currencySymbol"]).$this->ENGINE->format_number($allRatesArr[$oldRateKey], 2, false).($forOption? '' : '</del></b>');
			$adRateAcc[$i] = ($forOption? '' : '<b><ins class="">').$currencySymbol.$this->ENGINE->format_number($allRatesArr[$adRateKey], 2, false).($forOption? '' : '</ins></b>').$campaignMetas["adRateBaseFreq"].' '.
							($forOption? '' : '(<b>'.$currencySymbol.$this->ENGINE->format_number($perDayRate = ($allRatesArr[$adRateKey] / $campaignMetas["adBillBaseFreq"]), 2, false).'</b>/day, <b>'.$currencySymbol.$this->ENGINE->format_number(($perDayRate * 30), 2, false).'</b>/month)');
				
			if($banner1PremiumRate)
				$premiumRateAcc[$i] = ($forOption? '' : '<span class="maroon"><b>').$this->ENGINE->format_number($allRatesArr[$premiumRateKey], 2, false).($forOption? '' : '</b>').'% premium'.($forOption? '' : '</span>');
				
			if($banner1DiscountRate)
				$discountRateAcc[$i] = ($forOption? '' : '<span class="sky-blue"><b>').$this->ENGINE->format_number($allRatesArr[$discountRateKey], 2, false).($forOption? '' : '</b>').($discountIsPremium? '% premium discount' : '% discount').($forOption? '' : '</span>');
				
			
			if(($bannerType && $adType == $bannerType) || ($forTextCampaign && $adType == $textAdType))
				break;
			
			$i++;
			
		}
		
		$labCls = 'prime-1';
		$ear = "ear";
		
		switch(strtolower($type)){
			
			case "all_rates": 
				$ret = $allRatesArr; break;
				
			case "all": 
			case $ear: 
			$ear = ($type == $ear);
			$ret = '<div class="'.($ear? '' : ' pill-follower-stacked hr-dividers kp-1tbd pill-follower-unity ').' pill-followers pill-follower-transparent" >
						<div class="align-c">
							'.($onPremiumRate? '<span class="text-sticker text-sticker-warning" title="This section is currently on premium rate">now on premium rate</span><br/>' : '').'
							<span class="'.$labCls.'">Banner Ad Rate >></span>
							<div><b class="'.($KT='text-sticker text-sticker-info').'">'.$banner1Dimension.' >></b> '.(isset($oldRateAcc[$K=1])? $oldRateAcc[$K] : '').(isset($adRateAcc[$K])? $adRateAcc[$K] : '').(isset($premiumRateAcc[$K])? ' '.$premiumRateAcc[$K] : '').(isset($discountRateAcc[$K])? ', '.$discountRateAcc[$K] : '').'</div>
							<div class="hr-divider no-bg"><b class="'.$KT.'">'.$banner2Dimension.' >></b> '.(isset($oldRateAcc[$K=2])? $oldRateAcc[$K] : '').(isset($adRateAcc[$K])? $adRateAcc[$K] : '').(isset($premiumRateAcc[$K])? ' '.$premiumRateAcc[$K] : '').(isset($discountRateAcc[$K])? ', '.$discountRateAcc[$K] : '').'</div>
							<div class="hr-divider no-bg"><b class="'.$KT.'">'.$banner3Dimension.' >></b> '.(isset($oldRateAcc[$K=3])? $oldRateAcc[$K] : '').(isset($adRateAcc[$K])? $adRateAcc[$K] : '').(isset($premiumRateAcc[$K])? ' '.$premiumRateAcc[$K] : '').(isset($discountRateAcc[$K])? ', '.$discountRateAcc[$K] : '').'</div>
						</div>
						<div class=""><span class="'.$labCls.'">Text Ad Rate >></span> '.(isset($oldRateAcc[$K=4])? $oldRateAcc[$K] : '').(isset($adRateAcc[$K])? $adRateAcc[$K] : '').' '.(isset($premiumRateAcc[$K])? $premiumRateAcc[$K] : '').(isset($discountRateAcc[$K])? ', '.$discountRateAcc[$K] : '').'</div>
						'.($premiumRateFmt? '<div class=""><span class="'.$labCls.'">Premium Rate:</span> '.$premiumRateFmt.'</div>' : '').'
					</div>';
			!$ear? ($ret = '<a href="/estimated-ad-rates" class="btn btn-info btn-xs" data-toggle="smartToggler" data-animate="false" data-toggle-attr="text|Hide Ad Rates">View Ad Rates</a>
			<div class="row hide"><div class="col-lg-w-6'.($forTable? '' : ' center-block').'">'.($noHeader? '' : '<h4 class="page-title bg-dcyan pan">AD RATES</h4>').'<div class="">'.$ret.'</div></div></div>') : '';
			
			if($appendToAll){
				
				$allRatesArr[$type] = $ret;
				$ret = $allRatesArr;
				
			}
			
			break;	
			
			case "cear": $ret =  ' ('.(isset($adRateAcc[$K=1])? $banner1Dimension.': '.$adRateAcc[$K] : '').(isset($premiumRateAcc[$K])? ' '.$premiumRateAcc[$K] : '').(isset($discountRateAcc[$K])? ', '.$discountRateAcc[$K] : '').
									(isset($adRateAcc[$K=2])? (isset($adRateAcc[1])? ' | ' : '').$banner2Dimension.': '.$adRateAcc[$K] : '').(isset($premiumRateAcc[$K])? ' '.$premiumRateAcc[$K] : '').(isset($discountRateAcc[$K])? ', '.$discountRateAcc[$K] : '').
									(isset($adRateAcc[$K=3])? (isset($adRateAcc[2])? ' | ' : '').$banner3Dimension.': '.$adRateAcc[$K] : '').(isset($premiumRateAcc[$K])? ' '.$premiumRateAcc[$K] : '').(isset($discountRateAcc[$K])? ', '.$discountRateAcc[$K] : '').
									($forTextCampaign? ((isset($adRateAcc[$K=4])? $adRateAcc[$K] : '').(isset($premiumRateAcc[$K])? ' '.$premiumRateAcc[$K] : '').(isset($discountRateAcc[$K])? ', '.$discountRateAcc[$K] : '')) : '').
								')';
			break;
			
		}
		
		return $ret;
				
	}


	
	

 

	

 

	/* Method for fetching active ads on a section for impression */
	public function getSectionAds($sid){
		
		$pageBottomAds=$pageTopAds=$adsT2=$adsT3=$adsT4=$textCampaignPrefix="";
		$adType1Arr=$adType2Arr=$adType3Arr=$adType4Arr = array();
		
		$bannerCtrlCls = 'ad-disp-base banner-screen-dpn banner-ctrl';
		
		$pilotArr = array("DISPLAY_SITE_ADS", "BANNER_CAMPAIGN_DEFAULT_PLACE_HOLDER", 
						"TEXT_CAMPAIGN_DEFAULT_PLACE_HOLDER", "HOW_TO_RUN_AD_CAMPAIGN_TID");
		list($dispSiteAds, $camp1DPH, $camp2DPH, $howToRunCampaignUrlId) = getAutoPilotState($pilotArr);
		
		if($dispSiteAds){
			
			$howToRunCampaignUrl = $this->SITE->getThreadSlug($howToRunCampaignUrlId);
			
			$adTypesArr = $this->getCampaignAdTypesDetails();
			$banner1AdType = $this->getCampaignAdType1();
			$banner2AdType = $this->getCampaignAdType2();
			$banner3AdType = $this->getCampaignAdType3();
			$textAdType = $this->getCampaignAdType4();
		
			////GET THE ADS ON SECTION/////////
			foreach($adTypesArr as $adTypeArr){	

				$adsArr=array();
				
				$adType = $adTypeArr["adType"];
				$campaignType = $adTypeArr["campaignType"];
				$isTextCampaign = ($campaignType == $this->getTextCampaignType());
				$valArr = array($sid, $adType);
				$altCols = $isTextCampaign? ",LINK_TEXT" : ",AD_IMAGE";
				$campaignTable = $adTypeArr["campaignTable"];
				$slotLimit = $adTypeArr["slots"];
				$widgetClass = $adTypeArr["widgetClass"];
				$placeholderImg = $adTypeArr["placeholderImg"];
				
				$loc = $sid;
				
				$qry = "SELECT AD_ID,AD_URL".$altCols." FROM active_section_ads act JOIN ".$campaignTable." camp ON act.AD_ID=camp.ID
						WHERE (SECTION_ID=? AND AD_TYPE=? AND ACTIVE_TIME != 0)";
						
				/////////PDO QUERY////
				
				$sql = $qry;
				$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
				
				while($row = $this->DBM->fetchRow($stmt)){
					
					$campId = $row["AD_ID"];
					$campBanner = isset($row["AD_IMAGE"])? $row["AD_IMAGE"] : '';
					$linkText = isset($row["LINK_TEXT"])? $row["LINK_TEXT"] : '';
					$landPage = $row["AD_URL"];
					
					$typeContent = $isTextCampaign? $linkText : '<img  class="img-responsive hover-elevation" src="'.$this->mediaRootBanner.$campBanner.'" alt="'.$landPage.':ad banner"  />';
					
					$adsArr[] = '<div class="'.$widgetClass.'">'.$textCampaignPrefix.'<a rel="nofollow" href="/ctt/'.$campaignType.'/'.$this->INT_HASHER->encode($campId).'/'.$loc.'/?land_page='.urlencode($landPage).'" class="links '.($isTextCampaign? 'block' : '').'" title="'.$landPage.'">'.$typeContent.'</a></div>';										
					
				}
				
				$slotsFilled = count($adsArr);
				
				if((($camp1DPH && !$isTextCampaign) || ($camp2DPH && $isTextCampaign))){
					
					$typeContent = $isTextCampaign? 'How to place text ads on our community' : '<img class="img-responsive" src="'.$this->mediaRootBanner.$placeholderImg.'" alt="default ad banner"  />';
					
					while($slotsFilled < $slotLimit){
				
						$adsArr[] = '<div class="'.$widgetClass.'">'.$textCampaignPrefix.'<a rel="nofollow" href="'.$howToRunCampaignUrl.'" class="links">'.$typeContent.'</a></div>';
						$slotsFilled++;
				
					}
				}
				
				if($adType == $banner1AdType) 
					$adType1Arr = $adsArr;
				
				elseif($adType == $banner2AdType)
					$adType2Arr = $adsArr;
				
				elseif($adType == $banner3AdType)
					$adType3Arr = $adsArr;
				
				elseif($adType == $textAdType)
					$adType4Arr = $adsArr;
			
				
				if(is_array($adType1Arr)){
				
					shuffle($adType1Arr);
					
					$pageTopAds = array_slice($adType1Arr, 0, 3);
					
					$pageBottomAds = array_slice($adType1Arr, 3, 3);
														
					$pageTopAds = (!empty($pageTopAds))? '<div class="'.$bannerCtrlCls.' banner1-ctrl">'.implode("", $pageTopAds).'</div>' : '';			
					$pageBottomAds = (!empty($pageBottomAds))? '<div class="'.$bannerCtrlCls.' banner1-ctrl">'.implode("", $pageBottomAds).'</div>' : '';
					
				}
				
				if(is_array($adType2Arr)){
				
					shuffle($adType2Arr);
					
					$adsT2 = (!empty($adType2Arr))? '<div class="'.$bannerCtrlCls.'">'.implode("", $adType2Arr).'</div>' : '';						
				
				}
				
				if(is_array($adType3Arr)){
				
					shuffle($adType3Arr);
					$adsT3 = (!empty($adType3Arr))? '<div class="'.$bannerCtrlCls.'">'.implode("", $adType3Arr).'</div>' : '';
				
				}
				
				if(is_array($adType4Arr)){
				
					shuffle($adType4Arr);
					$adsT4 = (!empty($adType4Arr))? '<div class="ad-disp-base"><div class="widget side-widget text-widget"><div class="panel panel-limex"><h2 class="panel-head page-title head-bg-classic-r align-c">Sponsored Links</h2><div class="panel-body hr-dividers">'.implode("", $adType4Arr).'</div></div></div></div>' : '';	
				
				}
						
				
			}
		}

		return array("topAds" => $pageTopAds, "bottomAds" => $pageBottomAds, "adsT2" => $adsT2,
						"adsT3" => $adsT3, "adsT4" => $adsT4);
		
		
		
	}

	

 
	
	

 


 
	/* Method for fetching advertisers cost per week per campaign */
	public function getEstimatedCampaignCost($uid){
		
		$costAcc = 0;
		$campaignType = $this->getCampaignType();
		$campaignTable = $this->getCampaignTable();
		$isTextCampaign = $this->isTextCampaign();
		$maxPerDbRow = $this->DBM->getMaxRowPerSelect();
		
		for($ii=0; ; $ii += $maxPerDbRow){
			
			/////////PDO QUERY////////
			
			$sql =  "SELECT c.ID FROM ".$campaignTable." c JOIN active_section_ads a ON c.ID=a.AD_ID WHERE USER_ID=? AND AD_TYPE IN(".($isTextCampaign? $this->getTextAdTypesCommaList() : $this->getBannerAdTypesCommaList()).") GROUP BY c.ID LIMIT ".$ii.",".$maxPerDbRow;

			$valArr = array($uid);
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr, true);
			
			/////IMPORTANT INFINITE LOOP CONTROL ////
			if(!$this->DBM->getSelectCount())
				break;
						
			while($row = $this->DBM->fetchRow($stmt)){
				
				$adId = $row["ID"];
				
				//GET BY BILLING DURATION OF ONE WEEK(7 DAYS) CONVERTED TO MINS
				
				$costAcc += $this->adsBilling($fbCampType=$campaignType, $fbAdId=$adId, $forceBillCleanup=false, $getBillingComputationOnlyByDur=(7 * 24 * 60));
				
			}
			
		}
		
		$costPerWk = $costAcc;
		$costPerDay = ($costPerWk / 7.00);
		$costPerMn = ($costPerDay * 30.00);
		$currencySymbol = $this->getMeta("static")["currencySymbol"];
		
		return ('<span class="prime-1">Your '.ucwords($campaignType).' Campaign Current Advertising Cost:</span><span class="'.($K='pill-follower').'">'.$currencySymbol.$this->ENGINE->format_number($costPerDay, 2, false).'/day'.($costPerDay? '</span><span class="'.$K.'">'.$currencySymbol.$this->ENGINE->format_number($costPerWk, 2, false).'/week</span><span class="'.$K.'">'.$currencySymbol.$this->ENGINE->format_number($costPerMn, 2, false).'/month</span>' : ''));
		
	}








	 
	/* Method for computing the billing amount per ad per section */
	public function getComputedAdBilling($adOwnerId, $sectionId, $campaignType, $bannerType, $adActiveDur){
		
		$allRatesArr = $this->getAdRate(array("sid"=>$sectionId, "type"=>"all_rates"));
		$campaignMetas = $this->getMeta("static");
		$onPremiumRate = (bool)$allRatesArr["onPremiumRate"];
		$discountIsPremium = (bool)$allRatesArr["discountIsPremium"];
		
		###VERY IMPORTANT TO FETCH THE USER's AVAILABLE CREDITS ON THE FLY###
		$sql = "SELECT ADS_CREDITS_AVAIL,ADS_PREMIUM_PURSE FROM users WHERE ID=? LIMIT 1";
		$valArr = array($adOwnerId);
		$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
		$row = $this->DBM->fetchRow($stmt);
		$adOwnerPurse = $row["ADS_CREDITS_AVAIL"];
		$adOwnerPremiumPurse = abs((double)$row["ADS_PREMIUM_PURSE"]);
		
		################################################################################################
		
		/////COMPUTE BILLING USING SECTION AD RATE, DISCOUNT RATE AND ACTIVE DURATION/////
		/****
		NOTE:
			>> DEPENDING ON THE ADMIN, AD BILLING BASE UNIT COULD BE DAILY, WEEKLY, MONTHLY OR EVEN YEARLY
			>> ACTIVE DURATION IS IN MINUTES AND MUST BE CONVERTED TO SECONDS BY MULTIPLYING BY 60
			
		***/
		$adActiveDurInSec = ($adActiveDur * 60);
		
		/**************************************************************************************************
		GET AD RATE, DISCOUNT RATE AND PREMIUM RATE BASE ON THE CAMPAIGN AND AD TYPES
		**************************************************************************************************/
		
		if($campaignType == $this->getBannerCampaignType()){
		
			##FOR BANNER CAMPAIGN AD TYPES WE ARE APPLY RATES ACCORDINGLY
			switch($bannerType){
		
				case $this->getCampaignAdType2():
					$adRate = $allRatesArr["b2AdRate"];
					$discountRate = $allRatesArr["b2DiscountRate"];
					$premiumRate = $allRatesArr["b2PremiumRate"];
					break;
		
				case $this->getCampaignAdType3():
					$adRate = $allRatesArr["b3AdRate"];
					$discountRate = $allRatesArr["b3DiscountRate"];
					$premiumRate = $allRatesArr["b3PremiumRate"];
					break;
		
				default:
					$adRate = $allRatesArr["b1AdRate"];
					$discountRate = $allRatesArr["b1DiscountRate"];
					$premiumRate = $allRatesArr["b1PremiumRate"];
		
			}
		}
		##FOR TEXT CAMPAIGN AD TYPE WE ARE APPLY RATE ACCORDINGLY
		else{
		
			$adRate = $allRatesArr["textAdRate"];
			$discountRate = $allRatesArr["textDiscountRate"];
			$premiumRate = $allRatesArr["textPremiumRate"];
			
		}
		
		##ENFORCE TYPE CASTING
		$adRate = abs((double)$adRate);
		$discountRate = abs((double)$discountRate);
		$premiumRate = abs((double)$premiumRate);
		
		
		/**************************************************************************************************
		IF DEMAND IS HIGH FOR A PARTICULAR SECTION AND ADMIN(CRONJOB) HAS PLACED THE SECTION UNDER PREMIUM
		THEN APPLY THE PREMIUM RATE AS THE NEW AD RATE
		**************************************************************************************************/
		$computedPremiumRate = $computedPremiumDiscount = 0;
		
		if($onPremiumRate && $premiumRate){
			
			//SINCE PREMIUM RATE IS EXPRESSED AS A % OF THE AD RATE THAT IS TO BE ADDED TO THE AD RATE THEN
			$adRate = $computedPremiumRate = ($adRate + ($adRate * ($premiumRate / 100)));
			
		}
		
		
		
		
		##IF THERE IS DISCOUNT APPLICABLE TO THE SECTION COMPUTE ACCORDINGLY
		$totalDiscountPerCron = 0;
		$adBillBaseFreq = $campaignMetas["adBillBaseFreq"];
		$oneDaySecs = $campaignMetas["oneDaySecs"];
		
		#######COMPUTE DISCOUNT PER CRON FOR CAMPAIGN TYPE#######	
			
		if($discountRate){
			
			//ALTHOUGH IT WON'T HAPPEN SINCE IT'S BEING CHECKED PRIOR TO INSERT INTO DATABASE BUT STILL
			//IF ADMIN SETS A DISCOUNT RATE >= 100% THEN HE MUST BE SLEEPING OR DRUNK
			//LET'S ASSIST HIM BY SETTING A FALLBACK DISCOUNT AS FOLLOWS
			
			if($discountRate >= 100)
				$discountRate = $campaignMetas["fallBackDiscount"]; //DEFAULT UNREASONABLE DISCOUNTS TO THIS FALLBACK VALUE;
			
			//EVALUATE THE SECTION DISCOUNT
			$totalSectionDiscount = (($discountRate / 100) * $adRate);
			////DISCOUNT AFTER ONE BASE DAY ELAPSES:
			$totalDiscountPerDay = ($totalSectionDiscount / $adBillBaseFreq);
			////DISCOUNT AFTER ONE CRON FREQ ELAPSES:
			$totalDiscountPerCron = (($totalDiscountPerDay * $adActiveDurInSec) / $oneDaySecs);	
								
		}
		
		#######COMPUTE AD RATE PER CRON#######
		$totalAdRate = $adRate;
		////AD RATE AFTER ONE BASE DAY ELAPSES:
		$totalAdRatePerDay = ($totalAdRate / $adBillBaseFreq);
		////AD RATE AFTER ONE CRON FREQ ELAPSES:
		$totalAdRatePerCron = (($totalAdRatePerDay * $adActiveDurInSec) / $oneDaySecs);
		
		################################################################################################
		
		##############BILL USERS AND APPLY DISCOUNTS ACCORDINGLY (PER CRON)##########################
		/**
			DON'T APPLY DISCOUNTS >>>
					IF DISCOUNT IS PREMIUM AND THE AD OWNER IS NOT ON PREMIUM PACKAGE

		**/
		
		
		$amountBilled = ($discountIsPremium && !$adOwnerPremiumPurse)? $totalAdRatePerCron : ($totalAdRatePerCron - $totalDiscountPerCron);
		
		return array('amountBilled' => $amountBilled, 'adOwnerPurse' => $adOwnerPurse, 'adOwnerPremiumPurse' => $adOwnerPremiumPurse, 
				'adRate' => $adRate, 'totalAdRatePerCron' => $totalAdRatePerCron, 'discountRate' => $discountRate, 
				'discountIsPremium' => $discountIsPremium, 'totalDiscountPerCron' => $totalDiscountPerCron, 'premiumRate' => $premiumRate, 
				'onPremiumRate' => $onPremiumRate, 'computedPremiumRate' => $computedPremiumRate);
		
		
		
	}




	
	
	
	
	
	
	
	/* Method for uploading banners */
	public function adBannerUploader($bannerDimension){
		
		$file=$uok=$err=$bannerType='';
		
		$fSelected=true;	
		
		/////UPLOADING AD BANNER/////		
		switch($bannerDimension){
			
			case ($bannerDetails = $this->getBanner2Details())["dimension"]:
				$sizeLimit =  $bannerDetails["size"];
				$widthLimit = $bannerDetails["width"];
				$heightLimit = $bannerDetails["height"];
				$bannerType = $bannerDetails["campaignAdType"];
				break;
			
			case ($bannerDetails = $this->getBanner3Details())["dimension"]:
				$sizeLimit =  $bannerDetails["size"];
				$widthLimit = $bannerDetails["width"];
				$heightLimit = $bannerDetails["height"];
				$bannerType = $bannerDetails["campaignAdType"];
				break;
			
			default:
				$bannerDetails = $this->getBanner1Details();
				$sizeLimit =  $bannerDetails["size"];
				$widthLimit = $bannerDetails["width"];
				$heightLimit = $bannerDetails["height"];
				$bannerType = $bannerDetails["campaignAdType"];
				
		}
		
		$campaignMetas = $this->getMeta("static");
				
		###UPLOAD BANNER###
		##PRECONFIG UPLOADER
		$htmlName = 'ads_image';
		$uploadpath = $this->mediaRootBannerXCL;
		$allowedExtArr = BANNER_EXT_ARR;		
		$fileTerm = 'banner';
		$uploadType = 'single'; //UPLOADER INTELLIGENTLY DECODES THE TYPES
		
		$FU = new FileUploader($htmlName, $uploadpath, $allowedExtArr, $sizeLimit, $widthLimit, $heightLimit, $fileTerm);
				
		//EXPLICITLY SET OVERWRITE TO FALSE(THOUGH DEFAULT == false)
		$FU->setOverwrite(false);	
				
		//RENAME FILES
		$FU->setRename(true);
				
		//SET UNIT (KB)
		$FU->setSizeUnit('Kb');
				
		//SET BYTE TO (KB) CONVERSION BASE
		$FU->setByte2SizeUnit($campaignMetas["kb2Byte"]);
		
		if($FU->fileIsSelected()){
						
			$FU->upload();
			$uok = $FU->getUploadStatus();	
			$err = $FU->getErrors();												
			list($file) = $FU->getUploadedFiles(true);//RETURN UPLOADED FILE AS AN ARRAY								
				
		}else
			$fSelected = false;
		
		return array($file, $uok, $err, $bannerType, $fSelected);
		
	}
	
	
	
	
	
	
	
	
	
	

	/* Method for generating per campaign for campaign manager (template) */
	public function getPerCampaign($sql, $valArr, $submitURL, $totalRecords){
		
		$campaign="";
		
		if(!$submitURL)
			$submitURL = $this->pageSelf;
		
		if(!is_array($valArr))
			$valArr = (array)$valArr;
		
		$campaignType = $this->getCampaignType();
		
		///////////PDO QUERY/////
		$stmtx = $this->DBM->doSecuredQuery($sql, $valArr);
			
		while($campRow = $this->DBM->fetchRow($stmtx)){
			
			$approvalDisapprovalBtn="";
			
			$adOwnerUsername = $this->ACCOUNT->memberIdToggle($campRow["USER_ID"]);
			
			$approvalState = $campRow["APPROVAL_STATUS"];
			
			switch($approvalState){
				
				case $this->getApprovedAdState(): $approvalState = 'APPROVED'; $apprFav = 'fa-check'; break;
				case $this->getPendingAdState(): $approvalState = 'PENDING'; $apprFav = 'fa-clock'; break;
				case $this->getDisapprovedAdState(): $approvalState = 'DISAPPROVED'; $apprFav = 'fa-times'; break;
				
			}
			
			$approvalStateLC = strtolower($approvalState);
			$apprFav = $this->SITE->getFA($apprFav);
			
			$adIdCurr = $campRow["ID"];
			$adIdCurrEnc = $this->INT_HASHER->encode($adIdCurr);
			
			if($approvalStateLC == "pending" || $approvalStateLC == "disapproved")
				$approvalDisapprovalBtn = '<br/><button class="btn btn-success" data-toggle="smartToggler" data-id-targets="'.($tmp='ad-'.$adIdCurrEnc.'-approval').'">Approve</button>
								<div class="modal-drop hide" id="'.$tmp.'">
									<p>ARE YOU SURE?</p>
									<form method="post" action="/'.$submitURL.'#appr">
										<div class="field-ctrl">
											<input type="hidden" name="approval_action" value="Approve" />
											<input type="hidden" name="ad_id" value="'.$adIdCurrEnc.'" />
											<input type="submit" name="approve_campaign" class="btn btn-info" value="Approve" />		
										</div>
									</form>
									<button class="btn btn-success" data-toggle="smartToggler" data-id-targets="'.$tmp.'">Cancel</button>
								</div>';

			if($approvalStateLC != "disapproved")
				$approvalDisapprovalBtn .= '<hr/><button class="btn btn-danger" data-toggle="smartToggler" data-id-targets="'.($tmp='ad-'.$adIdCurrEnc.'-disapproval').'">Disapprove</button>
										<div class="modal-drop hide" id="'.$tmp.'">
											<p>ARE YOU SURE?</p>
											<form method="post" action="/'.$submitURL.'#appr">
												<div class="field-ctrl">
													<input type="hidden" name="approval_action" value="Disapprove" />
													<input type="hidden" name="ad_id" value="'.$adIdCurrEnc.'" />
													<input type="submit" name="approve_campaign" class="btn btn-danger" value="Disapprove" />	
												</div>	
											</form>
											<button class="btn btn-success" data-toggle="smartToggler" data-id-targets="'.$tmp.'">Cancel</button>
										</div>';
			
			if($approvalStateLC == 'pending')
				$approvalState = '<b class="cyan">'.$approvalState.$apprFav.'</b>'.$approvalDisapprovalBtn;

			elseif($approvalStateLC == 'disapproved'){
				$approvalState = '<b class="red">'.$approvalState.$apprFav.'</b>'.$approvalDisapprovalBtn.
								'<a role="button"  href="/delete-campaign?campaign='.$campaignType.'&ad='.$adIdCurrEnc.'&adm-ref='.$adOwnerUsername.'&_rdr='.$this->rdr.'"  class="btn btn-danger" data-toggle="smartToggler" data-campaign-id="'.$adIdCurrEnc.'" data-adm-ref="'.$adOwnerUsername.'" data-campaign="'.$campaignType.'" title="Delete this ad campaign" >delete</a>
								<div class="red hide modal-drop">
									Are You sure?<br>
									<input type="button" data-campaign-id="'.$adIdCurrEnc.'" data-adm-ref="'.$adOwnerUsername.'" data-campaign="'.$campaignType.'" class="btn btn-danger confirm-camp-del" value="OK" /> 									
									<input  class="btn close-toggle" type="button" value="CLOSE" /></b>
								</div>';

			}elseif($approvalStateLC == 'approved')
				$approvalState = '<b class="green">'.$approvalState.$apprFav.'</b>'.$approvalDisapprovalBtn;							
			
			$metaKey = 'edit_slug';
			$metaParams = array('adId' => $adIdCurrEnc);

			if(isset($campRow[$K="AD_IMAGE"])){
				
				$alternateTD = '<div class="widget banner-widget '.$campRow["BANNER_TYPE"].'"><a href="'.$this->SITE->getDownloadURL($campRow[$K], "ads").'" class="links zoom-ctrl" ><img class="img-responsive table-img" src="'.$this->mediaRootBanner.$campRow["AD_IMAGE"].'" alt="Ad Banner" /></a></div>';
				$alternateTH = '<th>BANNER</th>';
				$landPageEditUrl = $this->getMeta($metaKey, $this->ENGINE->extend_params($metaParams, array('type' => 'banner-lp')));
				$typeEditUrl = $this->getMeta($metaKey, $this->ENGINE->extend_params($metaParams, array('type' => 'banner')));
				
			}elseif(isset($campRow[$K="LINK_TEXT"])){
				
				$alternateTD = '<a href="'.$campRow["AD_URL"].'" class="links" >'.$campRow[$K].'</a>';
				$alternateTH = '<th>LINK TEXT</th>';
				$landPageEditUrl = $typeEditUrl = $this->getMeta($metaKey, $this->ENGINE->extend_params($metaParams, array('type' => 'text')));
				
			}
			
			
			$placementLoc = $this->adPlacementHandler(array('adId'=>$adIdCurr,'action'=>'get', 'retArr'=>true, 'sep'=>$sep='<hr/>'));		
			$placementLoc = (count($placementLoc) > $len=1)? (implode($sep, array_slice($placementLoc, 0, $len)).'<div class="v-constrict v-constrict-sm hide">'.$sep.implode($sep, array_slice($placementLoc, $len)).'</div><a role="button" class="btn btn-xs btn-sc" href="#" data-toggle="smartToggler" data-toggle-attr="text|less" data-target-prev="true">more</a>') : implode($sep, $placementLoc);
			$campaign .= '<tr class="campaign-base" id="'.$adIdCurrEnc.'">
									<td><span title="INT ID: '.$adIdCurr.'">'.$adIdCurrEnc.'</span></td>
									<td>'.$this->ACCOUNT->sanitizeUserSlug($adOwnerUsername, array('anchor'=>true)).'</td>
									<td>
										<a href="'.($landPageUrl = $campRow["AD_URL"]).'" class="links" >'.$landPageUrl.'</a>
										<a class="btn btn-xs btn-warning" href="/'.$landPageEditUrl.'" target="_blank">Edit</a>
									</td>
									<td>
										'.$alternateTD.'
										<a class="btn btn-xs btn-warning" href="/'.$typeEditUrl.'" target="_blank">Edit</a>
									</td>
									<td>'.$this->ENGINE->time_ago($campRow["TIME"]).'</td>									
									<td><div class="align-c">'.$approvalState.'</div></td>
									<td>'.$placementLoc.'</td>									
									<td>'.$campRow["CLICKS"].'</td>
									<td>'.$campRow["HITS"].'</td>
			
							</tr>';
		}
						
		$campaign = '<div class="table-responsive"><table class="table-classic">
								<h2 class="prime">'.$totalRecords.' campaign(s)</h2>
												<th>ID</th>
												<th>OWNER</th>
												<th>LANDING PAGE</th>
												'.$alternateTH.'
												<th>TIME UPLOADED</th>
												<th>APPROVAL</th>
												<th>PLACED IN</th>
												<th>CLICKS</th>
												<th>HITS</th>'
											.$campaign.
									'</table></div>';
				
		
		return $campaign;
		
	}



	
	
	
	




	/* Method for crediting or debiting advertisers with campaign credits */
	public function creditOrDebitAdvertiser($username, $amount, $action, $ignoreRdr=false){
		
		$alertUser=$rqdUname=$rqdCDAmt='';		
		$isDebit=$isCredit=false;
		$asterix = '<span class="asterix">*</span>';
		$usernameSlug = $this->ACCOUNT->sanitizeUserSlug($username);
		$uid = $this->ACCOUNT->memberIdToggle($username, true);
		
		if(stripos($action, 'credit') !== false){		
					
			$action = "credit";
			$isCredit = true;		
					
		}else{		
					
			$action = "debit";
			$isDebit = true;		
					
		}		
					
		
		$finalAmountArith = preg_replace("#[^0-9\.]#", '', $amount);
		$fmtdAmount = $this->ENGINE->format_number($finalAmountArith, 2, false);						
				
		
		if($username){
					
			$siteName = $this->SITE->getSiteName();			
			$siteDomain = $this->ENGINE->get_domain();			
			$sessUsername = $this->SESS->getUsername();
			$sessUsernameSlug = $this->SESS->getUsernameSlug();
						
			if($amount){
							
				///PDO QUERY////////
				
				$sql = "SELECT ID, EMAIL, ADS_PREMIUM_PURSE FROM users WHERE ID = ? LIMIT 1";
				$valArr = array($uid);
				$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
				$row = $this->DBM->fetchRow($stmt);				
				
				if(!empty($row)){
				
					$uidEmail = $row["EMAIL"];
					$userOldPremiumPurse = $row["ADS_PREMIUM_PURSE"];
					
					///////////GET ALL THE ADMINS//////
					
					list($adminEmails, $adminsIds) = $this->SITE->getAdmins("array-all");
					
					$premiumAmtSubQry = $this->getPremiumEligSubQry($finalAmountArith, $isCredit);
					
					if($isCredit){
						
						$cols = "ADS_CREDITS_AVAIL = (ADS_CREDITS_AVAIL + ?)".$premiumAmtSubQry;	
						$this->ACCOUNT->updateUser($uid, $cols, array($finalAmountArith));
													
						///ALERT THE CREDITED USER THROUGH PM//////

						///////////FORMAT LINKS IN PM//////
	
						$pmEncodedSessUsername = '[a '.$sessUsernameSlug.']'.$sessUsername.'[/a]';		
					
						$pmEncodedUsername = '[a '.$usernameSlug.']'.$username.'[/a]';		
						
						$pmEncodedAmount = '[spn class="blue"]'.$fmtdAmount.'[/spn]';
							
							
						$subject = "Ads Credit Alert From webmaster@".$siteName;

						$message =  $pmEncodedUsername." you have been credited with ".$pmEncodedAmount." advertising credits <br/> Thank you for advertising with us" ;
						
						//sender => "Webmaster"
						$senderId = 0;	
						$U = $this->ACCOUNT->loadUser($uid);																
						$receiverId = $U->getUserId();
						$this->SITE->sendPm($senderId, $receiverId, $subject, $message);		

						////////ALERT THE CREDITED USER THROUGH EMAIL//////
					
						$to = $uidEmail;

						$subject = 'Ads Campaign Credit Notification';
								
						$message = '<a href="'.$siteDomain.'/'.$usernameSlug.'">'.$username.'</a> You have been credited with <b '.EMS_PH_PRE.'GREEN>'.$fmtdAmount.'</b> advertising credits\n\n Thank You for advertising with us\n\nBest regards,\n<a href="'.$siteDomain.'">'.$siteName.'</a> Ads Campaign Team\n\n\n';
									
						$footer = 'NOTE: This email was sent to you because you purchased Ads credit at <a href="'.$siteDomain.'">'.$siteDomain.'</a> \nPlease kindly ignore this email if otherwise.';								 
								 
						$this->SITE->sendMail(array('to'=>$to.'::'.$U->getFirstName(), 'subject'=>$subject, 'body'=>$message, 'footer'=>$footer));
						
						/////ALERT THE ADMINS//////
						
						///////////FORMAT LINKS IN PM///////
	
						$pmEncodedSessUsername = '[a '.$sessUsernameSlug.']'.$sessUsername.'[/a]';		
					
						$pmEncodedUsername = '[a '.$usernameSlug.']'.$username.'[/a]';		
						
						$pmEncodedAmount = '[spn class="blue"]'.$fmtdAmount.'[/spn]';
						
						///ALERT THE ADMINS THROUGH PM///
						$adminsIdsArr = explode(",", $adminsIds);
						
						$subject = 'Ads Credit By '.$pmEncodedSessUsername.'@'.$siteName;

						$message =  $pmEncodedUsername.' has been credited with '.$pmEncodedAmount.' advertising credits <br/> Administrators  should please take note.';
						
						//sender => "Webmaster"
						$senderId = 0;									
						
						foreach($adminsIdsArr as $adminId)
							$this->SITE->sendPm($senderId, $adminId, $subject, $message);	
								
											
					
						///////////////ALERT THE ADMINS THROUGH EMAIL//////

						$to = $adminEmails;

						$subject = 'Ads Credit By '.$sessUsername.'@'.$siteName;;
								
						$message = '<a href="'.$siteDomain.'/'.$usernameSlug.'">'.$username.'</a>  has been credited with <b '.EMS_PH_PRE.'GREEN>'.$fmtdAmount.'</b> advertising credits\n\n All Administrators should please take note.';
									
						$footer = 'NOTE: This email was sent to you because you are an Administrator at <a href="'.$siteDomain.'">'.$siteDomain.'</a>';
								 
						$this->SITE->sendMail(array('to'=>$to, 'senderName'=>'Webmaster & '.$sessUsername, 'subject'=>$subject, 'body'=>$message, 'footer'=>$footer));
						
						$alertUser = '<span class="alert alert-success"> You have successfully <span class="blue"><b>credited</b> </span><a href="/'.$usernameSlug.'" class="links" >'.$username.'</a> with <span class="blue">'.$fmtdAmount.'</span>  campaign credits</span>';
						
						if($ignoreRdr)
							return $fmtdAmount;
							
						////// REDIRECT TO AVOID PAGE REFRESH DUPLICATE ACTION//////////
						$this->SITE->formGateRefresh($alertUser);
			
					}elseif($isDebit){
																		
						///////////PDO QUERY/////
				
						$sql = "SELECT ADS_CREDITS_AVAIL FROM users WHERE ID=? LIMIT 1";
						$valArr = array($uid);
						
						$oldAdCredits = $this->DBM->doSecuredQuery($sql, $valArr)->fetchColumn();
							
						if($oldAdCredits >= $finalAmountArith){				
								
							$cols = "ADS_CREDITS_AVAIL = (ADS_CREDITS_AVAIL - ?)".$premiumAmtSubQry;	
							$this->ACCOUNT->updateUser($uid, $cols, array($finalAmountArith));
							///////////ALERT THE DEBITED USER THROUGH PM//////

							///////////FORMAT LINKS IN PM/////////
							
							$pmEncodedSessUsername = '[a '.$sessUsernameSlug.']'.$sessUsername.'[/a]';
							
							$pmEncodedUsername = '[a '.$usernameSlug.']'.$username.'[/a]';
							
							$pmEncodedAmount = '[spn class="red"]'.$fmtdAmount.'[/spn]';
							
							$subject = 'Ads Debit Alert From webmaster@'.$siteName;

							$message =  $pmEncodedUsername.' you have been debited with '.$pmEncodedAmount.' advertising credits <br/> If there is any form of inconsistency with this debit, Please contact us at [em]'.CONTACT_US_EMAIL_ADDR.'[/em]<br/> Thank You';
							
							//sender => "Webmaster"	
							$senderId = 0;																					
							$U = $this->ACCOUNT->loadUser($uid);																																
							$receiverId = $U->getUserId();
							$this->SITE->sendPm($senderId, $receiverId, $subject, $message);																	

							////////ALERT THE DEBITED USER THROUGH EMAIL//////
						
							$to = $uidEmail;

							$subject = 'Ads Campaign Debit Notification';
									
							$message = '<a href="'.$siteDomain.'/'.$usernameSlug.'">'.$username.'</a> You have been debited with <b '.EMS_PH_PRE.'RED>'.$fmtdAmount.'</b> advertising credits\n\n If there is any form of inconsistency with this debit, Please contact us at '.CONTACT_US_EMAIL_ADDR.'\n\n Thank You for advertising with us \n\nBest regards,\n<a href="'.$siteDomain.'">'.$siteName.'</a> Ads Campaign Team\n\n\n';
										
							$footer = 'NOTE: This email was sent to you because you are running an ad campaign at <a href="'.$siteDomain.'">'.$siteDomain.'</a> \nPlease kindly ignore this email if otherwise.';
									 
							$this->SITE->sendMail(array('to'=>$to.'::'.$U->getFirstName(), 'subject'=>$subject, 'body'=>$message, 'footer'=>$footer));
							
							////ALERT THE ADMINS///
							
							///////////FORMAT LINKS IN PM/////
		
							$pmEncodedSessUsername = '[a '.$sessUsernameSlug.']'.$sessUsername.'[/a]';
							
							$pmEncodedUsername = '[a '.$usernameSlug.']'.$username.'[/a]';
							
							$pmEncodedAmount = '[spn class="red"]'.$fmtdAmount.'[/spn]';
							
							////ALERT THE ADMINS THROUGH PM//////								
							$adminsIdsArr = explode(",", $adminsIds);
								
							$subject = 'Ads Debit By '.$pmEncodedSessUsername.'@'.$siteName;

							$message =  $pmEncodedUsername.' has been debited with '.$pmEncodedAmount.' advertising credits <br/> Administrators should please take note.';
							//sender => "Webmaster"
							$senderId = 0;											
							
							foreach($adminsIdsArr as $adminId)
								$this->SITE->sendPm($senderId, $adminId, $subject, $message);
							
											
							//////////ALERT THE ADMINS THROUGH EMAIL//////
	
							$to = $adminEmails;

							$subject = 'Ads Debit By '.$sessUsername.'@'.$siteName;
									
							$message = '<a href="'.$siteDomain.'/'.$usernameSlug.'">'.$username.'</a> has been debited with <b '.EMS_PH_PRE.'RED>'.$fmtdAmount.'</b> advertising credits\n\n All Administrators should please take note.';
										
							$footer = 'NOTE: This email was sent to you because you are an Administrator at <a href="'.$siteDomain.'">'.$siteDomain.'</a>';
									 
							$this->SITE->sendMail(array('to'=>$to, 'senderName'=>'Webmaster & '.$sessUsername, 'subject'=>$subject, 'body'=>$message, 'footer'=>$footer));
																						
							$alertUser = '<span class="alert alert-success"> You have successfully <span class="red"><b>debited</b></span> <a href="/'.$usernameSlug.'" class="links" >'.$username.'</a> with <span class="blue">'.$fmtdAmount.'</span>  campaign credits</span>';
							
							if($ignoreRdr)
								return true;
						
							////// REDIRECT TO AVOID PAGE REFRESH DUPLICATE ACTION//////////
							$this->SITE->formGateRefresh($alertUser);

						}else
							$alertUser = '<span class="alert alert-danger">Sorry the user <a href="/'.$usernameSlug.'" class="links" >'.$username.'</a> only has <span class="blue">'.$oldAdCredits.' credit(s)</span> available in account<br/> 
							Unfortunately the account won\'t be able to forfeit the requested amount at the moment.<br/> 
							You can either try debiting the account at some other time when enough credit is available<br/>
							or better still debit the amount currently available and debit the rest at some other time.</span>';
					
					}						
					
				}else
					$alertUser = '<span class="alert alert-danger">Sorry the user <a href="/'.$usernameSlug.'" class="links" >'.$username.'</a> was not found. Please verify the username you entered and try again.</span>';			
			
			}else{
								
				$alertUser = '<span class="alert alert-danger">Please select or enter the amount !</span>';
				$rqdCDAmt = $asterix;
								
			}
			
		}else						
			$rqdUname = $asterix;
	
		return array($alertUser, $fmtdAmount, $action, $rqdUname, $rqdCDAmt);
	
	}
	
	
	



	/* Method for dispatching campaign approval/disapproval email notifications */
	public function notifyApprovalByEmail($memberUsername, $approvalTxtHtml, $adId){
		
		$siteName = $this->siteName;
		$siteDomain = $this->siteDomain;
		$adIdEnc = $this->INT_HASHER->encode($adId);
		$campaignType = $this->getCampaignType();
		
		$email = $this->ACCOUNT->getUserEmail($memberUsername,"campaign_ntf");
		
		if($email){						
		
			///SEND NOTIFICATION EMAIL IF ALLOWED/////													
			$to = $email;
			$firstName = $this->ACCOUNT->loadUser($memberUsername)->getFirstName();
			$approvalTxtHtml = trim($approvalTxtHtml);
			
			$subject = 'Your Ad Has Been '.strip_tags($approvalTxtHtml);
			 
			$message = 'Hello '.$this->ACCOUNT->sanitizeUserSlug($memberUsername, array('anchor'=>true, 'youRef'=>false, 'preUrl'=>$siteDomain, 'isRel'=>false)).', \n  Your '.$campaignType.' Ad with ID: <a href="'.$siteDomain.'/ads-campaign/'.$campaignType.'-campaign#'.$adIdEnc.'"><b>'.$adIdEnc.'</b></a> has been '.$approvalTxtHtml.'\n <div '.EMS_PH_PRE.'BLUE_BOX_1>'.$approvalTxtHtml.' ON: '.date(' l, dS M, Y, \a\t h:iA').'</div> \nThank you for Advertising with Us.\n\nBest regards,\n<a href="'.$siteDomain.'">'.$siteName.'</a> Ads Campaign Team\n\n\n';
						
			$footer = 'NOTE: This email was sent to you because you are running an ad campaign at  <a href="'.$siteDomain.'">'.$siteDomain.'</a>. Please kindly ignore this message if otherwise.\n\n\n Please do not reply to this email.';
					
			$this->SITE->sendMail(array('to'=>$to.'::'.$firstName, 'subject'=>$subject, 'body'=>$message, 'footer'=>$footer));
		}
		
		return ($this->ACCOUNT->memberIdToggle($memberUsername, true));
		
	}






	/* Method for fetching useful campaign notes */
	public function getCampaignNote($type='', $cssCls=''){
		
		$isTopStaff = $this->SESS->getUltimateLevel();
		$campaignMetas = $this->getMeta("static") ;
		
		$premiumDiscountNote = '<div class="prime '.$cssCls.'">
									>>> To fill or renew your premium purse and enjoy premium discounts, you will need to purchase at least <b class="">'.$campaignMetas["currencySymbol"].$this->ENGINE->format_number($campaignMetas["premiumEligibilityAmount"], 2, false).$campaignMetas["currency"].'</b>  
									advertising credits at a go.
								</div>';
		
		$reapprovalNote = '<div class="'.$cssCls.'">
								Whenever You modify a campaign by editing a banner(for banner campaign) or a link text(for text campaign), the campaign will be removed from all sections it`s currently
								active in and will have to undergo the approval stage again. This will in turn place You at bottom of the sort queue.
							</div>';
		
		$reapprovalShortNote = '<div class="align-l bold text-danger '.$cssCls.'">
									NOTE: Editing this will cause the Ad to be removed from all pages where it`s currently active and it will have to undergo the approval stage again.
								</div>';
		
		switch(strtolower($type)){
			
			case 're-approval-short': $note = $isTopStaff? '' : $reapprovalShortNote; break;
			
			case 're-approval': $note = $reapprovalNote; break;
			
			case 'premium-discount': $note = $premiumDiscountNote; break;
			
			default: $note = $premiumDiscountNote;
			
		}
		
		return $note	;
		
	}







	/* Method for fetching ad hits and clicks sub query */
	public function getAdHitsNClicksSubQry($adIdPH, $campTypePH){
		
		(trim($campTypePH) == '?')? '' : ($campTypePH = "'".$campTypePH."'");
		
		$hitsSubQry = ", (SELECT COUNT(DISTINCT SOURCE_USER_ID, IP) FROM ".($table="ad_traffic_reports").($cnd=" WHERE (AD_ID=".$adIdPH." AND CAMPAIGN_TYPE=".$campTypePH.")").") AS HITS";
		$clicksSubQry = ", (SELECT COUNT(*) FROM ".$table.$cnd.") AS CLICKS";
		
		return ($hitsSubQry.$clicksSubQry);
		
	}





	 
	/* Method for masking and fetching campaign pause/resume url */
	public function getPauseNResumeURL($rdr="", $retArrAll=false){
		
		$tk = $this->ENGINE->generate_token(); 
		$flChr = $this->ENGINE->generate_fixed_length_char(60);
		$campaignType = $this->getCampaignType();
		
		####NOTE: THE rpt QSTR IS THE ONLY VALID QSTR (THE 1 AND 2 TO ITS RIGHT) WHILE THE REST QSTR IS A MASK#####
		
		$rdr = $rdr? $rdr : $this->siteDomain.'/ads-campaign/'.$campaignType.'-campaign';
		$rpUrl = '/rp-campaign?'.($rpUrlToken = 'uluk='.$tk.'&rpt='.$flChr.'_'.$campaignType.'&_rdr='.$rdr);
		
		
		if($retArrAll)	
			return array($rpUrl, $rpUrlToken);
		
		return $rpUrl;

	}
	 

		

		

			
	/* Method for populating credit amount select option for campaign manager */
	public function getCreditAmountOptions($amt, $dcp=2){
		
		$crdOptions='';
		
		for($i=500; ;){
			
			$iFmt = $this->ENGINE->format_number($i, $dcp, false);
			$crdOptions .= '<option '.(($amt == $iFmt)? 'selected' : '').'>'.$iFmt.'</option>';
			if($i < 3000) $i += 500;
			elseif($i < 10000) $i += 1000;
			elseif($i < 20000) $i += 5000;
			elseif($i < 100000) $i += 10000;
			elseif($i <= 1000000) $i += 50000;
			if($i > 1000000) break;						
		}
		
		return '<option value="0">Select credit amount</option>'.$crdOptions;	
		
	}




	
	
	
	
	/* Method for fetching ad details as card */
	public function getCampaignDetailsCard($metaArr){
			
		$uid = $this->ENGINE->get_assoc_arr($metaArr, 'uid');
		$adId = $this->ENGINE->get_assoc_arr($metaArr, 'adId');
		$adIdEnc = $this->ENGINE->get_assoc_arr($metaArr, 'adIdEnc');
		$append = $this->ENGINE->get_assoc_arr($metaArr, 'append');
		
		if(!$uid)
			return '';
		
		///////////PDO QUERY////

		$sql =  "SELECT c.*".$this->getAdHitsNClicksSubQry('c.ID', '?')." FROM ".$this->getCampaignTable()." c WHERE c.USER_ID=? AND c.ID=? LIMIT 1";

		$valArr = array(($campaignType = $this->getCampaignType()), $campaignType, $uid, $adId);
		$stmt = $this->DBM->doSecuredQuery($sql, $valArr, true);		
		
		if(!$uid || !$this->DBM->getRecordCount())
			return '';
			
		$row = $this->DBM->fetchRow($stmt);		
		$url = $row["AD_URL"];
		$hits = $row["HITS"];
		$clicks = $row["CLICKS"];
		$adOwnerId = $row["USER_ID"];
		$adOwnerUsername = $this->ACCOUNT->memberIdToggle($adOwnerId);
		
		if(isset($row["AD_IMAGE"]))
			$alternateTypes = '<label class="flab">AD BANNER:</label>
								<div class="ad-disp-base" ><div class="widget banner-widget '.$row["BANNER_TYPE"].'"><img class="img-responsive" src="'.$this->mediaRootBanner.($adImg = $row["AD_IMAGE"]).'" alt="ad banner" title="'.$adImg.'->'.$url.'" /></div></div>';
								
		elseif(isset($row["LINK_TEXT"]))
			$alternateTypes = '<label class="flab">LINK TEXT: </label>'.$row["LINK_TEXT"];
			
		$url = $this->ENGINE->add_http_protocol($url);
						
		
		return	'<div class="base-b-mg"><div class="panel panel-limex col-sm-w-5">
					<h2 class="panel-head page-title">Ad Details</h2>					
					<ul class="panel-body hr-dividers">
						<li class="pill-followers">
							<span><label class="flab">ID: <span class="cyan">'.$adIdEnc.'</span></label></span>
							<span><label class="flab">OWNER: '.$this->ACCOUNT->sanitizeUserSlug($adOwnerUsername, array('anchor'=>true, 'gender'=>false, 'youRef'=>false)).'</label></span>
						</li>
						<li class="">'.$alternateTypes.'</li>
						<li class=""><label class="flab">LANDING PAGE: </label>'.$url.'</li>
						<li class="pill-followers">
							<span><label class="flab">CLICKS: </label><b class="cyan">'.(isset($clicks)? $this->ENGINE->format_number($clicks) : '').'</b></span>
							<span><label class="flab">HITS: </label><b class="cyan">'.(isset($hits)? $this->ENGINE->format_number($hits) : '').'</b></span>
						</li>
					</ul>
				</div><hr/></div>';	
		
	}




	
	
	
	
	/* Method for processing ad upload page requests */
	public function processAdUploadPageRequest(){
		
		$notLogged=$uploadError=$uploadLimitError=$landingPage=$alert=$linkText="";
		
		$sessUsername = $this->SESS->getUsername();
		$sessUid = $this->SESS->getUserId();
		$campaignMetas = $this->getMeta("static");
		list($bannerDimensionSelectMenu, $bannerDimensionPassed) = $this->populateBannerDimensionSelectMenu(true);
		list($autoInstantApprovalField, $autoInstantApprovalStatus) = $this->getAutoInstantApprovalBtn(true);
		
		if($sessUsername){

			////////MONITOR UPLOAD MAX POST LENGTH/////
			$uploadLimitError = $this->ENGINE->get_large_upload_limit_error();

			if(isset($_POST["upload_ads"])){
				
				if(isset($_POST[$K="linkText"]))	
					$linkText = $this->ENGINE->sanitize_user_input($_POST[$K]);

				$landingPage = $this->ENGINE->sanitize_user_input($_POST["landing_page"]);				
				$adCreditAvail = $this->SESS->getAdCreditAvailable();
				$totalCampaign = $this->countCampaign($sessUid);
				$campaignMetas = $this->getMeta("static");
						
				if(($totalCampaign >= CAMPAIGN_LOW_CREDIT_LIMIT && $adCreditAvail >= $campaignMetas["minAdPlaceCredit"]) ||  ($totalCampaign < CAMPAIGN_LOW_CREDIT_LIMIT) ||  $this->SESS->isAdmin()){
																																				
					if($this->landingPageValidated($landingPage)){		
						
						if($this->isBannerCampaign() || ($this->isTextCampaign() && $linkText && mb_strlen($this->ENGINE->filter_line_chars($linkText)) <= $campaignMetas["maxTextAdLink"])){
							
							/////UPLOADING AD BANNER/////
							if($this->isBannerCampaign())				
								list($newfn, $uok, $uploadError, $bannerType, $fSelected) = $this->adBannerUploader($bannerDimensionPassed);
							
							//pass these two checks below for textCampaignType
							else
								$fSelected = $uok = true;
							
							
							if($fSelected){			
								
								if($uok){
									
									$approvalStatus = $autoInstantApprovalStatus? $this->getApprovedAdState() : $this->getPendingAdState();//SET APPROVAL STATUS
											
									////PDO QUERY///
									
									$sql = "INSERT INTO ".$this->getCampaignTable()." (USER_ID, AD_URL, ".($this->isBannerCampaign()? 'BANNER_TYPE, AD_IMAGE,' : 'LINK_TEXT,')." APPROVAL_STATUS ,TIME ) VALUES(?,?,".($this->isBannerCampaign()? '?,' : '')."?,?,NOW())";
									$valArr = $this->isBannerCampaign()? array($sessUid, $landingPage, $bannerType, $newfn, $approvalStatus) : array($sessUid, $landingPage, $linkText, $approvalStatus);
									$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
									$insertId = $this->DBM->getLastInsertId();///GET THE ID AND FOCUS ON RDR/////
									
									///////////////UPDATE CAMPAIGN STATUS TO ACTIVE//////////
										
									$this->ACCOUNT->updateUser($sessUsername, ($this->isBannerCampaign()? 'BANNER' : 'TEXT').'_CAMPAIGN_STATUS=1');
															

									header("Location:/ads-campaign/".($this->isBannerCampaign()? 'banner' : 'text')."-campaign#".$this->INT_HASHER->encode($insertId));
									exit();

								}
								
								
							}
							else
								$alert = '<span class="alert alert-danger">Please browse and select a banner file from your device</span>';
						}
						else				
							$alert = '<span class="alert alert-danger">'.((mb_strlen($this->ENGINE->filter_line_chars($linkText)) > $campaignMetas["maxTextAdLink"])? 'Sorry your descriptive text is too long. Please redefine it to a maximum 200 characters (including spaces).' : 'Please enter a descriptive Text for your Ad').'</span>';				
							
					}
					else{
						
						if($landingPage && strtolower($landingPage) != "http://" && strtolower($landingPage) != "https://")
							$alert = $this->getMeta('landpage_error_tip');
						
						else
							$alert = '<span class="alert alert-danger">Please specify the landing page to use for your Ad</span>';
						
					}

				}else
					$alert = '<span class="alert alert-danger">Sorry you are low on campaign credits. Please purchase more advertising credits to enable you upload more campaigns.<br/>Thank You.</span>';
				
			}

		}
		else
			$notLogged = $this->notLoggedMsg;

		return array('bannerDimensionSelectMenu'=>$bannerDimensionSelectMenu, 'linkText'=>$linkText, 'landPage'=>$landingPage, 'alert'=>$alert, 
			'instantApprovalBtn'=>$autoInstantApprovalField, 'notLogged'=>$notLogged, 'uploadError'=>$uploadError, 'uploadLimitError'=>$uploadLimitError);
	}


	
	
	
	
	
	/* Method for editing campaign banner */
	public function editAdBanner($adIdPassed=0){
	
		$uploadError=$alert=$alertAdmins=$specialPriv=$adOwnerId="";		
		
		////////MONITOR UPLOAD MAX POST LENGTH/////
		$uploadLimitError = $this->ENGINE->get_large_upload_limit_error();
		
		list($bannerDimensionSelectMenu, $bannerDimensionPassed) = $this->populateBannerDimensionSelectMenu(true);
		list($autoInstantApprovalField, $autoInstantApprovalStatus) = $this->getAutoInstantApprovalBtn(true);
		
		$sessUid = $this->SESS->getUserId();
		
		if($adIdPassed){
			
			///////////PDO QUERY///////
			if($this->SESS->isAdmin()){
				
				$sql =  "SELECT AD_IMAGE, USER_ID, BANNER_TYPE FROM banner_campaigns WHERE ID=? LIMIT 1";
				$valArr = array($adIdPassed);
				$alertAdmins = $this->SITE->getMeta('ad-mods-alert');
				$specialPriv = true;
				
			}else{
				
				$sql =  "SELECT AD_IMAGE, USER_ID, BANNER_TYPE FROM banner_campaigns WHERE USER_ID=? AND ID=? LIMIT 1";
				$valArr = array($sessUid, $adIdPassed);
				
			}
			
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
			$row = $this->DBM->fetchRow($stmt);
			
			if(!empty($row)){
					
				$oldBanner = $row["AD_IMAGE"];
				$adOwnerId = $row["USER_ID"];
				$bannerTypeCss = $row["BANNER_TYPE"];
				
				//DONT ALERT ADMINS IF HE'S THE AD OWNER////
				if($sessUid == $adOwnerId){$alertAdmins=$specialPriv='';}
					
			}else
				$alert = '<span class="alert alert-danger">sorry you do not have the privilege to edit this Ad</span>';		
		}else
			$adOwnerId = $sessUid;
		
		////IF CHANGE OF BANNER IS SET///////////////////

		if(isset($_POST["change_banner"])){	

			$adIdEnc = $_POST["ad_id"];
			$adId = $this->ENGINE->sanitize_number($this->INT_HASHER->decode($adIdEnc));		
			
			///FETCH THE OLD BANNER NAME FROM DB SO THAT IT CAN BE DELETED FROM SERVER AFTER THE CHANGE IS DONE//////
						
			////PDO QUERY///////
				
			$sql = "SELECT AD_IMAGE, BANNER_TYPE FROM banner_campaigns WHERE ID=? AND USER_ID = ? LIMIT 1";
			$valArr = array($adId, $adOwnerId);
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
			$row = $this->DBM->fetchRow($stmt);
			
			if(!empty($row)){
					
				$oldBanner = $row["AD_IMAGE"];
				$oldBannerType = $row["BANNER_TYPE"];
				
			}

			
			/////UPLOADING AD BANNER/////				
			list($newfn, $uok, $uploadError, $bannerType, $fSelected) = $this->adBannerUploader($bannerDimensionPassed);
			
			if($fSelected){						
				
				if($uok){
								
					$approvalStatus = $autoInstantApprovalStatus? $this->getApprovedAdState() : $this->getPendingAdState();//SET APPROVAL STATUS
					
					///////////PDO QUERY////////////////
					
					$sql = "UPDATE banner_campaigns SET  BANNER_TYPE = ?, AD_IMAGE=?, APPROVAL_STATUS=? WHERE USER_ID=? AND ID=? ";
					$valArr = array($bannerType, $newfn, $approvalStatus, $adOwnerId, $adId);
					$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
								
					/////////REMOVE THE AD WITH THIS BANNER FROM ACTIVE ADS UNTIL ITS APPROVED AGAIN///////
					if(!$this->SESS->isAdmin() || ($bannerType != $oldBannerType))	
						$this->removeFromActiveAdSlots(array("adId"=>$adId));
							
					$path2del = $this->mediaRootBannerXCL.$oldBanner;

					if(realpath($path2del))	
						unlink($path2del);	
					
					if($adIdPassed && !$specialPriv && $retUrl = (isset($_GET[$K="_rdr"])? $_GET[$K] : '')){	
												
						header("Location:".$retUrl."#".$adIdEnc);
						exit();
						
					}else{
						$uploadError = '<span class="alert alert-success" '._TIMED_FADE_OUT.' data-click-to-hide="true">Done!</span>';
						
						////// REDIRECT TO AVOID PAGE REFRESH DUPLICATE ACTION//////////
						$this->SITE->formGateRefresh(array($uploadError, $adIdEnc), '', '#'.$adIdEnc);
					}

				}

			}else
				$uploadError = '<span class="alert alert-danger">Please browse and select a banner file from your device</span>';
			
		}
		
		return array('bannerDimensionSelectMenu'=>$bannerDimensionSelectMenu, 'alert'=>$alert, 'adOwnerId' => $adOwnerId, 'alertAdmins' => $alertAdmins,
			'instantApprovalBtn'=>$autoInstantApprovalField, 'fid' => isset($adIdEnc)? $adIdEnc : '', 'uploadError'=>$uploadError, 'uploadLimitError'=>$uploadLimitError);
		
	}

	
	
	
	

	/* Method for editing banner campaign landing page */
	public function editBannerAdLandPage($adIdPassed=0){
		
		$error=$alert=$alertAdmins=$specialPriv=$rawLand=$adOwnerId="";		
		
		$sessUid = $this->SESS->getUserId();
		
		
		if($adIdPassed){
				
			///////////PDO QUERY/////
			if($this->SESS->isAdmin()){
				
				$sql = "SELECT AD_URL,USER_ID FROM banner_campaigns WHERE ID=? LIMIT 1 ";
				$valArr = array($adIdPassed);
				$alertAdmins = $this->SITE->getMeta('ad-mods-alert');
				$specialPriv = true;
				
			}else{
				
				$sql = "SELECT AD_URL,USER_ID FROM banner_campaigns WHERE USER_ID=? AND ID=? LIMIT 1 ";
				$valArr = array($sessUid, $adIdPassed);
				
			}	
			
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
			$row = $this->DBM->fetchRow($stmt);
			
			if(!empty($row)){
				
				$url = $row["AD_URL"];
				$rawLand = $url;
				$adOwnerId = $row["USER_ID"];
				
				//DONT ALERT ADMINS IF HE'S THE AD OWNER////
				if($sessUid == $adOwnerId){$alertAdmins=$specialPriv='';}
				
				$old_land = $this->ENGINE->add_http_protocol($url);
				
			}else
				$alert = '<span class="alert alert-danger">sorry you do not have the privilege to edit this Ad</span>';
			
		}else
			$adOwnerId = $sessUid;
		
		////IF CHANGE OF LANDPAGE IS SET////////
		if(isset($_POST["change_Landpage"])){
			
			$landingPage = $this->ENGINE->sanitize_user_input($_POST["landing_page"]);
			$adIdEnc = $_POST["ad_id"];
			$adId = $this->ENGINE->sanitize_number($this->INT_HASHER->decode($adIdEnc));			
				
			if($this->landingPageValidated($landingPage)){
					
				///////////PDO QUERY//////
			
				$sql = "UPDATE banner_campaigns SET AD_URL=? WHERE USER_ID=? AND ID=? LIMIT 1 ";
				$valArr = array($landingPage, $adOwnerId, $adId);
				$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
				
				if($adIdPassed && !$specialPriv && $retUrl = (isset($_GET[$K="_rdr"])? $_GET[$K] : '')){
			
					header("Location:".$retUrl."#".$adIdEnc);
					exit();
					
				}else{
					$error = '<span class="alert alert-success" '._TIMED_FADE_OUT.' data-click-to-hide="true">Done!</span>';
					
					////// REDIRECT TO AVOID PAGE REFRESH DUPLICATE ACTION//////////				
					$this->SITE->formGateRefresh(array($error, $adIdEnc), '', '#'.$adIdEnc);
				}
				
			}else{
				
				if($landingPage && strtolower($landingPage) != "http://" && strtolower($landingPage) != "https://")	
					$error = $this->getMeta('landpage_error_tip');
					
				else
					$error = '<span class="alert alert-danger">The landing page is required</span>';
				
			}


		}

		return array("error" => $error, "alert" => $alert, "alertAdmins" => $alertAdmins, "adOwnerId" => $adOwnerId,
					"rawLand" => $rawLand, "postedLand" => isset($landingPage)? $landingPage : '', "fid" => isset($adIdEnc)? $adIdEnc : '');
	}


	
	
	
	
	/* Method for editing text campaign link text/landing page */
	public function editTextAdDetails($adIdPassed=0){
	
		$error=$alert=$alertAdmins=$old_land=$oldLinkText=$landingPage=$linkText=$approvalStatus=$rawLand=
		$specialPriv=$adOwnerId="";		
		
		list($autoInstantApprovalField, $autoInstantApprovalStatus) = $this->getAutoInstantApprovalBtn(true);
		
		$sessUid = $this->SESS->getUserId();
		$campaignMetas = $this->getMeta("static");
		
		
		if($adIdPassed){
			
			///////////PDO QUERY/////
			if($this->SESS->isAdmin()){
				
				$sql = "SELECT AD_URL, LINK_TEXT, USER_ID FROM text_campaigns WHERE ID=? LIMIT 1 ";
				$valArr = array($adIdPassed);
				$alertAdmins = $this->SITE->getMeta('ad-mods-alert');
				$specialPriv = true;
				
			}else{
				
				$sql = "SELECT AD_URL, LINK_TEXT, USER_ID FROM text_campaigns WHERE USER_ID=? AND ID=? LIMIT 1 ";
				$valArr = array($sessUid, $adIdPassed);
				
			}
				
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
			$row = $this->DBM->fetchRow($stmt);
			
			if(!empty($row)){
				
				$url = $row["AD_URL"];
				$rawLand = $url;
				$oldLinkText = $row["LINK_TEXT"];
				$adOwnerId = $row["USER_ID"];
				
				//DONT ALERT ADMINS IF HE'S THE AD OWNER////
				if($sessUid == $adOwnerId){$alertAdmins=$specialPriv='';}
				$old_land = $this->ENGINE->add_http_protocol($url);
				
			}else
				$alert = '<span class="alert alert-danger">sorry you do not have the privilege to edit this Ad</span>';					
		}else
			$adOwnerId = $sessUid;
			
		///IF CHANGE TEXT AD DETAILS IS SET////	
		if(isset($_POST["update_details"])){
			
			if(isset($_POST["linkText"]))
				$linkText = $this->ENGINE->sanitize_user_input($_POST["linkText"]);
			
			if(isset($_POST["landing_page"]))	
				$landingPage = $this->ENGINE->sanitize_user_input($_POST["landing_page"]);
			
			$adIdEnc = $_POST["ad_id"];
			$adId = $this->ENGINE->sanitize_number($this->INT_HASHER->decode($adIdEnc));
				
			///////////PDO QUERY//////
			$sql = "SELECT LINK_TEXT FROM text_campaigns WHERE USER_ID=? AND ID=? LIMIT 1 ";
			$valArr = array($adOwnerId, $adId);
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
			$row = $this->DBM->fetchRow($stmt);
								
			$oldText = $row["LINK_TEXT"];
			if(str_word_count($oldText) != str_word_count($linkText))
				$txtChanged = true;
			
			//FOR LINK TEXT CHANGES////
			if(isset($_POST["linkText"])){
				
				if($linkText && mb_strlen($this->ENGINE->filter_line_chars($linkText)) <= $campaignMetas["maxTextAdLink"]){
					
					if(isset($txtChanged))
						$approvalStatus = ", APPROVAL_STATUS=".($autoInstantApprovalStatus? $this->getApprovedAdState() : $this->getPendingAdState());
					///////////PDO QUERY//////
				
					$sql = "UPDATE text_campaigns SET LINK_TEXT=? ".$approvalStatus." WHERE USER_ID=? AND ID=? LIMIT 1 ";
					$valArr = array($linkText, $adOwnerId, $adId);
					
					if($this->DBM->doSecuredQuery($sql, $valArr)){
						
						/////////REMOVE THE AD FROM ACTIVE ADS UNTIL ITS APPROVED AGAIN////////
						if(isset($txtChanged) && !$this->SESS->isAdmin())
							$this->removeFromActiveAdSlots(array("adId"=>$adId));
						
					}

				}else{
					
					if(mb_strlen($this->ENGINE->filter_line_chars($linkText)) > $campaignMetas["maxTextAdLink"])
						$error = '<span class="alert alert-danger">Sorry your descriptive text is too long. Please redefine it to a maximum of 200 characters (including spaces).</span>';
					
					else
						$error = '<span class="alert alert-danger">You must enter a descriptive Text for your changes to take effect</span>';
					
				}
			}
			
			
			//FOR LANDING PAGE CHANGES////
			if(isset($_POST["landing_page"])){
				
				if($this->landingPageValidated($landingPage)){
						
					///////////PDO QUERY//////
				
					$sql = "UPDATE text_campaigns SET AD_URL=? WHERE USER_ID=? AND ID=? LIMIT 1 ";
					$valArr = array($landingPage, $adOwnerId, $adId);
					$stmt = $this->DBM->doSecuredQuery($sql, $valArr);				

				}else{
					
					if($landingPage && strtolower($landingPage) != "http://" && strtolower($landingPage) != "https://")
						$error .= $this->getMeta('landpage_error_tip');					
							
					else
						$error .= '<span class="alert alert-danger">The landing page is required</span>';			
				}
			}
			if(!$error){
			
				if($adIdPassed && !$specialPriv && $retUrl = (isset($_GET["_rdr"])? $_GET['_rdr'] : '')){
			
					header("Location:".$retUrl."#".$adIdEnc);
					exit();
			
				}else{
					$error = '<span class="alert alert-success" '._TIMED_FADE_OUT.' data-click-to-hide="true">Done!</span>';
					
					////// REDIRECT TO AVOID PAGE REFRESH DUPLICATE ACTION//////////
					$this->SITE->formGateRefresh(array($error, $adIdEnc), '', '#'.$adIdEnc);
				}
			}
		}

		return array("error" => $error, "alert" => $alert, "alertAdmins" => $alertAdmins, "oldLandPage" => $old_land, "adOwnerId" => $adOwnerId,
		"rawLand" => $rawLand, "postedLand" => isset($landingPage)? $landingPage : '', "oldLinkText" => $oldLinkText, "fid" => isset($adIdEnc)? $adIdEnc : '', 'instantApprovalBtn'=>$autoInstantApprovalField);
	}
	
	
	
	
	
	
	
	
	
	/* Method for generating campaign placement removal btn and metas */
	public function getPlacementRemovalBtn($metaArr, $retRemovalBtn=false){
		
		$sid = $metaArr['sid']; 
		$sectionPlaced = $metaArr['scatPlaced']; 
		$adId = $metaArr['adId']; 
		$adIdEnc = $metaArr['adIdEnc'];
		$activeOnly = $metaArr['activeOnly']; 
		$rdr = $metaArr['rdr']; 
		$idHash = $metaArr['idHash'];
		$scatTerm = $metaArr['scatTerm']; 
		$delIcon = $this->delIcon; 
		$time = $this->ENGINE->time_ago($metaArr['time']); 
		$tipMsg = ($activeOnly? 'Became active in ' : 'Placed on ').$sectionPlaced.' '.$time; 
		$tipId = 'plc-tip-'.($activeOnly? 'x-' : '').$sid; 
		
		if(!$retRemovalBtn)
			$cfmRemovalDrop = '<div class="alert alert-danger hide has-close-btn has-caretX">
									<p><span class="text-warning">Remove Campaign: '.$adIdEnc.' From '.$sectionPlaced.' '.($activeOnly? '(<span class="green">Active Now</span>)' : '').'</span><br/> ARE YOU SURE?</p>
									'.$this->getPlacementRemovalBtn($metaArr, true).'
									<button type="button" class="btn close-toggle">CLOSE</button>
								</div>';
		$removalBtn = '<a href="/remove-ad-from-section?campaign='.$this->campaignType.'&ad='.$adIdEnc.'&section='.$sid.($activeOnly? '&active_only=true' : '').'&_rdr='.$rdr.$idHash.'" data-ad-id="'.$adIdEnc.'" data-sid="'.$sid.'"  data-campaign="'.$this->campaignType.'" '.($activeOnly? 'data-active-only="true"' : '').' class="'.($retRemovalBtn? 'remove-placement close-toggle btn btn-danger' : 'no-hover-bg').'" '.($retRemovalBtn? 'role="button"' : ' data-toggle="smartToggler" data-align-to-context="true" title="Remove ad from '.$sectionPlaced.(($sid ==  HOMEPAGE_SID)? '' : $scatTerm).'" ').' >'.($retRemovalBtn? 'YES' : $delIcon).'</a>';
		
		return ($retRemovalBtn? $removalBtn : '<div class="per-plc-rmv-base inline-block">'.$this->ENGINE->sanitize_slug((($sid ==  HOMEPAGE_SID)? '' : $sectionPlaced), array('ret'=>'url', 'urlText'=>$sectionPlaced, 'urlAttr'=>'data-field-tip="true" data-tip-loader="'.$tipId.'" data-tip-w="180" data-tip-xoffset="10"')).' '.$removalBtn.$cfmRemovalDrop.'<span id="'.$tipId.'" class="hide">'.$tipMsg.'</span> ,</div> ');
		
	}


	
	
	
	
	
	/* Method for generating campaign placement collective removal btn and metas */
	public function getPlacementRemovalGrpBtn($metaArr, $retRemovalBtn=false){
		
		$grpSid = $metaArr['grpSid'];  
		$adId = $metaArr['adId']; 
		$adIdEnc = $metaArr['adIdEnc'];
		$activeOnly = $metaArr['activeOnly']; 
		$rdr = $metaArr['rdr']; 
		$idHash = $metaArr['idHash'];
		$term = $activeOnly? 'active' : 'pending';
		$termUCF = ucwords($term);
		$removalBtn = '<a role="button" href="/remove-ad-from-section?campaign='.$this->campaignType.'&ad='.$adIdEnc.'&section='.$grpSid.($activeOnly? '&active_only=true' : '').'&_rdr='.$rdr.$idHash.'" data-ad-id="'.$adIdEnc.'"   data-sid="'.$grpSid.'" data-campaign="'.$this->campaignType.'" '.($retRemovalBtn? 'data-hide-all="true"' : '').($activeOnly? ' data-active-only="true"' : '').' class="'.($retRemovalBtn? 'remove-placement' : 'btn-xs').' btn btn-danger" '.($retRemovalBtn? '' : ' data-toggle="smartToggler" data-align-to-context="true" ').' title="Remove all '.$term.' placement for AD: '.$adIdEnc.'">'.($retRemovalBtn? 'YES' : 'Remove All '.$termUCF.$this->FA_times).'</a>';
		if(!$retRemovalBtn)
			$cfmRemovalDrop = '<div class="alert alert-danger hide has-close-btn">
									<p><span class="text-warning">Remove All '.$termUCF.' Placement For Campaign: '.$adIdEnc.'</span><br/> ARE YOU SURE?</p>
									'.$this->getPlacementRemovalGrpBtn($metaArr, true).'
									<button type="button" class="btn close-toggle">CLOSE</button>
								</div>';
		
		return ($retRemovalBtn? $removalBtn : $removalBtn.$cfmRemovalDrop);
	}
						

	
	
	
	
	/* Method for removing ad placement on placement a multiple scale */
	public function adPlacementMultiRemove(){
		
		if(isset($_POST["rmfloc"])){
			
			if(!empty($_POST["rmfloc_locs"])){
				
				$locs='';
				$activeOnly = '&active_only='.(isset($_POST["mrmv_ao"])? 'true' : 'false');
				$locs_arr = $_POST["rmfloc_locs"];
				
				foreach($locs_arr as $perLoc){
					
					$locs .= $this->SITE->sectionIdToggle($this->ENGINE->sanitize_user_input($this->filterSectionRates($perLoc))).'_';
					
				}
				
				$locs = trim($locs, '_');
				$allCampIds='';	
				
				if($locs){
					
					header("Location:/remove-ad-from-section?campaign=".$this->campaignType."&ad=".SESS_ALL."&section=".$locs.$activeOnly."&_rdr=".$this->rdr);
					exit();
					
				}else
					$alert = '<span class="alert alert-danger">Please make a selection</span>';
			}else
				$alert = '<span class="alert alert-danger">Please make a selection</span>';
			
			$this->SITE->formGateRefresh(array($alert, 'mrmv'), '', 'mrmv');
			
		}
	}

	






	


	/* Method for checking if ad placement limit is exceeded */
	public function placementExceeded($adId, $retArr = false){
		
		$adCreditAvail = $this->SESS->getAdCreditAvailable();
		$campaignMetas = $this->getMeta("static");
		
		$totalCampaignPlcm = $this->adPlacementHandler(array('adId'=>$adId, 'action'=>'count'));

		$lowCrdLim = (	!$this->SESS->isAdmin() 
					&& $adCreditAvail < $campaignMetas["minAdPlaceCredit"] 
					&& $totalCampaignPlcm >= MAX_SECTIONS_PLACEABLE_ON_LOW_CRD
		);
		
		$limExceeded = ($lowCrdLim || $totalCampaignPlcm >= MAX_SECTIONS_PLACEABLE);

		return ($retArr? array('exceeded' => $limExceeded, 'lowCrdLim' => $lowCrdLim) : $limExceeded);

	}




	


	/* Method for doing single ad placement */
	public function doSinglePlacement(){
		
		if(isset($_POST["place_in_section"]) && $this->SESS->getUserId()){
			
			$sectionName = $this->ENGINE->sanitize_user_input($_POST["campaign_location"]);
			
			$adIdEnc = $_POST["ad_id"];
			$adId = $this->ENGINE->sanitize_number($this->INT_HASHER->decode($adIdEnc));

			if($sectionName){
				
				$sectionName = $this->filterSectionRates($sectionName);
				$sectionId = $this->SITE->sectionIdToggle($sectionName);
				
				//LIMIT AD PLACEMENT TO SECTIONS 
				$plcLimitArr = $this->placementExceeded($adId, true);

				if($plcLimitArr['exceeded']){

					$cmt = $plcLimitArr['lowCrdLim']? 'Sorry you are low on campaign credits. please purchase more advertising credits to enable you place your ads on more sections' 
					: 'Sorry in order to accommodate all our advertisers` needs, ad placements are limited to a maximum of '.MAX_SECTIONS_PLACEABLE.' sections per campaign';

					$alert = '<span class="alert alert-danger">'.$cmt.'</span>';

				}else{
					
					if($sectionId){
						
						/////PLACE THE AD IN THAT SECTION ONLY IF IT HAS NOT BEEN PLACED ALREADY//////
						if(!($this->adPlacementHandler(array('adId'=>$adId, 'sid'=>$sectionId, 'action'=>'check')))){
								
							$this->adPlacementHandler(array('adId'=>$adId, 'sid'=>$sectionId, 'action'=>'add'));																															
							
							$alert = '<span class="alert alert-success">Your ad with ID: <b class="cyan bg-white">'.$adIdEnc.'</b> was successfully placed in <b class="blue bg-white">'.$sectionName.'</b></span>';
								
						}else
							$alert = '<span class="alert alert-danger">Sorry that ad has already been placed in <span class="blue">'.$sectionName.'</span> before</span>';
						
					}else
						$alert = '<span class="alert alert-danger">Oops! Something went wrong; <span class="blue">'.$sectionName.'</span> section was not found please try again! </span>';	
					
				}					

			}else
				$alert = '<span class="alert alert-danger">Please make a selection</span>';

			////// REDIRECT TO AVOID PAGE REFRESH DUPLICATE ACTION//////////
			$this->SITE->formGateRefresh(array($alert, $adIdEnc), '', '#'.$adIdEnc);

			
		}
	}







	/* Method for doing multiple ad placement */
	public function doMultiPlacement(){
		
		$alert='';
		$plcErrArr=$plcErr2Arr=$plcErr3Arr=array();	
		$mplcFocus = false;
		
		if(isset($_POST["place_in_all_sections"]) && ($sessUid = $this->SESS->getUserId()) && ($campaignTable = $this->getCampaignTable())){								
			
			if(!empty($_POST[$K="campaign_location"])){
				
				$sectionNameArr = $_POST[$K];
				$totSel = count($sectionNameArr);
						
				foreach($sectionNameArr as $sectionName){
					
					$sectionName = $this->ENGINE->sanitize_user_input($sectionName);
					
					if(!$sectionName && $totSel == 1){
						
						$alert = $mplcFocus = '<span class="alert alert-danger">Please make a selection</span>';
						break;
						
					}elseif(!$sectionName)
						continue;
					
					$sectionName = $this->filterSectionRates($sectionName);
					$sectionId = $this->SITE->sectionIdToggle($sectionName);
					
					if($sectionId){
						
						$maxPerDbRow = $this->DBM->getMaxRowPerSelect();
						
						for($i=0; ; $i += $maxPerDbRow){
							
							////////PDO QUERY/////
							
							$sql = "SELECT ID FROM ".$campaignTable." WHERE USER_ID=? LIMIT ".$i.",".$maxPerDbRow;
							$valArr = array($sessUid);
							$stmt = $this->DBM->doSecuredQuery($sql, $valArr, true);
							
							/////IMPORTANT INFINITE LOOP CONTROL ////
							if(!$this->DBM->getSelectCount())
								break;
						
							while($row = $this->DBM->fetchRow($stmt)){
								
								$adId = $row["ID"];
								
								##PLACE THE AD IN THAT SECTION ONLY 
								
								##IF IT HAS NOT BEEN PLACED ALREADY								
								if($this->adPlacementHandler(array('adId'=>$adId, 'sid'=>$sectionId, 'action'=>'check'))){
									
									if(!in_array($sectionName, $plcErrArr))
										$plcErrArr[] = $sectionName;
									
									continue;
					
								}
								
								##IF IT HAS'NT EXCEEDED MAX NUMBER OF SECTION PLACEABLE
								
								if($this->placementExceeded($adId)){
					
									if(!in_array($sectionName, $plcErr2Arr))
										$plcErr2Arr[] = $sectionName;
					
									$nPlcErr = true;
									continue;
					
								}
								
								$this->adPlacementHandler(array('adId'=>$adId, 'sid'=>$sectionId, 'action'=>'add'));																															
								$nSuccess = true;
					
							}
														
										
							$alert = isset($nPlcErr)? '<div class="alert alert-danger">Some(or all) of your Ads was`nt placed in the following section(s) as they have clocked maximum number of sections placeable:<div class="blue">'.implode(', ', $plcErr2Arr).'</div></div>' : '';						
							$alert = (isset($nSuccess)? '<span class="alert alert-success">Some(or all) of your Ads were successfully placed in the selected section(s)</span>' : '').$alert;
							
						}
						
					}else
						$plcErr3Arr[] = $sectionName;	
								
				}
					
				$plcErr = implode(', ', $plcErrArr);
				$alert = ($plcErr? '<div class="alert alert-danger">oops! it seems some(or all) of your ads are already in the following section(s) <div class="blue">'.$plcErr.'</div></div>' : '').$alert;
				$plcErr = implode(', ', $plcErr3Arr);
				$alert = ($plcErr? '<div class="alert alert-danger">Oops! Something went wrong; we could`nt find the following section(s) <div class="blue">'.$plcErr.'</div>please try again! </div>'  : '').$alert;

			}else
				$alert = $mplcFocus = '<span class="alert alert-danger">Please make a selection</span>';
			
			////// REDIRECT TO AVOID PAGE REFRESH DUPLICATE ACTION//////////
			$hash = $mplcFocus? 'mplc' : 'cfhd';
			$mplcFocus? ($alert = array($alert, $hash)) : '';
			$this->SITE->formGateRefresh($alert, '', $hash);

			
		}
	}

	
	
	
	
	
	
	/* Method for doing ad placement */
	public function adPlacementHandler($metaArr){
		
		$acc=array();
		
		$adId = $this->ENGINE->get_assoc_arr($metaArr, 'adId');
		$sidArr = (array)$this->ENGINE->get_assoc_arr($metaArr, 'sid');
		$uid = $this->ENGINE->get_assoc_arr($metaArr, 'uid');
		$fetchAll = (bool)$this->ENGINE->get_assoc_arr($metaArr, 'fetchAll');
		$sep = $this->ENGINE->get_assoc_arr($metaArr, 'sep');		
		$retArr = (bool)$this->ENGINE->get_assoc_arr($metaArr, 'retArr');		
		$ignoreCampaignType = (bool)$this->ENGINE->get_assoc_arr($metaArr, 'ignoreCampaignType');		
		$i = $this->ENGINE->get_assoc_arr($metaArr, 'i');
		$i = $i? $i : 0;
		$n = $this->ENGINE->get_assoc_arr($metaArr, 'n');	
		$n = $n? $n : 30;
		$action = strtolower($this->ENGINE->get_assoc_arr($metaArr, 'action'));	
					
		$sidArr = array_filter($sidArr, function($v){ return is_numeric($v);});
		$sidRef = empty($sidArr)? false : true;
		$sidPH = $sidRef? rtrim(str_repeat("?,", count($sidArr)), ",") : '';
		$campaignType = $this->getCampaignType();
		
		if($adId && $campaignType){
			
			$valArr = array($adId);
			
			if(in_array($action, array('check','add','del')) && $sidRef){
				
				$valArr = array_merge($valArr, $sidArr);
				$valArr[] = $campaignType;
				
				if($action == 'check'){
					
					$sql = "SELECT ID FROM ad_pending_placements WHERE (AD_ID=? AND SECTION_ID IN(".$sidPH.") AND CAMPAIGN_TYPE=?)";
					
					return $this->DBM->doSecuredQuery($sql, $valArr)->fetchColumn();
					
					
				}elseif($action == 'add'){
					
					$adminOvCol=$valPH='';
					$adminOverride = getAutoPilotState('AD_PLACEMENT_ADMIN_OVERRIDE');
					
					if($adminOverride){
						
						$adminOverrideSortTime = $this->ENGINE->get_date_safe('', '', array('mdfMeta'=>'-5 year'));
						$adminOvCol = ',TIME'; $valPH = ',?';
						$valArr[] = $adminOverrideSortTime;
						
					}
					
					$sql = "INSERT INTO ad_pending_placements (AD_ID, SECTION_ID, CAMPAIGN_TYPE ".$adminOvCol.") VALUES(?,?,?".$valPH.")";
					
					return $this->DBM->doSecuredQuery($sql, $valArr);
					
				}elseif($action == 'del'){
					
					$sql = "DELETE FROM ad_pending_placements WHERE (AD_ID=? AND SECTION_ID IN(".$sidPH.") AND CAMPAIGN_TYPE=?)";
					
					return $this->DBM->doSecuredQuery($sql, $valArr);
					
				}
				
			}elseif($action == 'count'){
				
				$valArr[] = $campaignType;
				$sql = "SELECT COUNT(*) FROM ad_pending_placements WHERE (AD_ID=? AND CAMPAIGN_TYPE=?)";
				
				return $this->DBM->doSecuredQuery($sql, $valArr)->fetchColumn();
				
					
			}elseif($action == 'get'){
				
				$valArr[] = $campaignType;
				$sql = "SELECT * FROM ad_pending_placements WHERE (AD_ID=? AND CAMPAIGN_TYPE=?) ORDER BY TIME ASC LIMIT ".$i.",".$n;
				$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
				
				if($fetchAll)
					return $this->DBM->fetchRows();
				
				while($row = $this->DBM->fetchRow($stmt)){
					
					$acc[] = $this->ENGINE->sanitize_slug($this->SITE->sectionIdToggle($row["SECTION_ID"]), array('ret'=>'url')).' - '.$this->ENGINE->time_ago($row["TIME"]);
					
				}
				
				return ($retArr? $acc : implode($sep, $acc));
				
			}
			
		}elseif($action == 'del-by-uid' && $uid){
			
			if($ignoreCampaignType){
				
				$valArr = array($uid, $uid);
				$subQry = "(AD_ID IN(SELECT ID FROM ".$this->getBannerCampaignTable()." WHERE USER_ID=?) OR AD_ID IN(SELECT ID FROM ".$this->getTextCampaignTable()." WHERE USER_ID=?))";	
				
			}else{
				
				$valArr = array($uid, $campaignType);
				$subQry = "AD_ID IN(SELECT ID FROM ".$this->getCampaignTable()." WHERE USER_ID=?)"; 
				
			}
				
			$sidRef? ($valArr = array_merge($valArr, $sidArr)) : '';
			
			$sql = "DELETE FROM ad_pending_placements 
			WHERE (".$subQry.
					($ignoreCampaignType? "" : " AND CAMPAIGN_TYPE = ? ").
					($sidRef? " AND SECTION_ID IN(".$sidPH.") " : "").
			")";
			
			
			return $this->DBM->doSecuredQuery($sql, $valArr);
				
		}
		
	}

	
	
	
	
	
	
	
	
	

	/* Method for removing ad from active slots */
	public function removeFromActiveAdSlots($metaArr){
		
		$adId = $this->ENGINE->get_assoc_arr($metaArr, 'adId');
		$uid = $this->ENGINE->get_assoc_arr($metaArr, 'uid');
		$sidArr = (array)$this->ENGINE->get_assoc_arr($metaArr, 'sid');
		$del = (bool)$this->ENGINE->get_assoc_arr($metaArr, 'del');
		$ignoreCampaignAdType = (bool)$this->ENGINE->get_assoc_arr($metaArr, 'ignoreCampaignAdType');
		$action = strtolower($this->ENGINE->get_assoc_arr($metaArr, 'action'));
		$activeAdsTable = ' active_section_ads ';
		
		$sidArr = array_filter($sidArr, function($v){ return is_numeric($v);});
		$sidRef = empty($sidArr)? false : true;
		$sidPH = $sidRef? rtrim(str_repeat("?,", count($sidArr)), ",") : '';
		$adType = $this->isBannerCampaign()? $this->getBannerAdTypesCommaList() : $this->getTextAdTypesCommaList();
		$campaignType = $this->getCampaignType();
		$updateSubQry = " SET MINUTES_ACTIVE_BEFORE = (MINUTES_ACTIVE_BEFORE +  COALESCE(TIMESTAMPDIFF(MINUTE, ACTIVE_TIME, NOW()), 0)), ACTIVE_TIME=0 ";
		
		if($adId && $adType){
			
			$valArr = array($adId);
			$sidRef? ($valArr = array_merge($valArr, $sidArr)) : '';
			$sql =  ($del? "DELETE FROM ".$activeAdsTable : "UPDATE ".$activeAdsTable.$updateSubQry)." 
					WHERE (AD_ID=? AND AD_TYPE IN(".$adType.") ".($sidRef? " AND SECTION_ID IN(".$sidPH.") " : "").")";
			
			$this->DBM->doSecuredQuery($sql, $valArr);
			
		}elseif($uid){
			
			if($ignoreCampaignAdType){
				
				$valArr = array($uid, $uid);
				$subQry = "(AD_ID IN(SELECT ID FROM ".$this->getBannerCampaignTable()." WHERE USER_ID=?) OR AD_ID IN(SELECT ID FROM ".$this->getTextCampaignTable()." WHERE USER_ID=?))";	
				
			}else{
				
				$valArr = array($uid);
				$subQry = "AD_ID IN(SELECT ID FROM ".$this->getCampaignTable()." WHERE USER_ID=?)"; 
				
			}
			
			$sidRef? ($valArr = array_merge($valArr, $sidArr)) : '';		
			$sql = ($del? "DELETE FROM ".$activeAdsTable : "UPDATE ".$activeAdsTable.$updateSubQry)." 
			WHERE (".$subQry.
					($ignoreCampaignAdType? "" : " AND AD_TYPE IN(".$adType.")").
					($sidRef? " AND SECTION_ID IN(".$sidPH.") " : "").
			")";
					
			$this->DBM->doSecuredQuery($sql, $valArr);
			
		}
		
		
		return true;
		
	}



	



	/* Method for removing ad residual rows from other ad related tables 
	Note: database cascaded delete was traded off since the possibility of a 
	user calling this method on a daily basis is near zero */
	public function adDelCleanUp($adId){
		
		$done = true;
		
		if($adId && ($campaignType = $this->getCampaignType())){
			
			$tableArr = array('ad_billings','ad_pending_placements','ad_traffic_reports');
				
			foreach($tableArr as $table){
				
				$sql = "DELETE FROM ".$table." WHERE (AD_ID=? AND CAMPAIGN_TYPE=?)";
				$valArr = array($adId, $campaignType);
				$done = $this->DBM->doSecuredQuery($sql, $valArr);
				
			}	
			
		}
		
		return $done;
		
	}







	/* Method for generating users campaign (Template) */
	public function generateCampaign(){
		
		$alertUser=$allCampaign=$options=$availSection=$pagination=$campaignStatus=$sid=$uploadError=
		$uploadLimitError=$error=$updateAlert=$campaignNotify=$filterCnd=$filter=$orderBy="";
		
		$campaignAccArr = array();

		$credits_avail=$credits_used=$prmPurse=0;
		
		$sessUsername = $this->SESS->getUsername();
		$sessUid = $this->SESS->getUserId();	
		$pageSelfFlt = $this->ENGINE->get_page_path('page_url', '', true);	
		$sessAlert = $this->ENGINE->get_global_var('ss', 'SESS_ALERT');	

		$isBannerCampaign=$isTextCampaign=false;
		
		$campaignType = $this->getCampaignType();
		$campaignMetas = $this->getMeta("static");
		$pageId = 1;
		
		if($this->isBannerCampaign()){
		
			$campaignTable = $this->getBannerCampaignTable();
			$cstat_col = 'BANNER_CAMPAIGN_STATUS';			
			$landpage_fs_name = 'change_Landpage';
			$pageUrl = $forceRDR = 'ads-campaign/banner-campaign';						
			$isBannerCampaign = true;
			$lpHash = '';
		
		}else{
		
			$campaignTable = $this->getTextCampaignTable();
			$cstat_col = 'TEXT_CAMPAIGN_STATUS';			
			$landpage_fs_name = 'update_details';
			$pageUrl = $forceRDR = 'ads-campaign/text-campaign';
			$isTextCampaign = true;
			$lpHash = '#lp';
		
		}
			
		
		$cmnToggleTgtDatas = ' class="alert alert-danger has-caret hide has-close-btn" ';		
		
		//////////GET FORM-GATE RESPONSE//////////	
		list($alertPer, $formId) = $this->SITE->formGateRefreshResponse(true);	

		$ntfActKey = 'activate_ntfy';
		$ntfDeactKey = 'deactivate_ntfy';

		$orderSessKey = 'CAMPAIGN_oby';
		$orderKey = 'oby';
		$filterSessKey = 'TYPE_filter';
		$filterKey = 'filter';
		
		$orderList = array(//FORMAT => urlSlug:urlLabel:urlIcon:ignoreCond
			($defaultOrder = $uploadTimeOrder = 'upload-time'), ($hitsOrder = 'hits')
		);
		
		$filterList = array(//FORMAT => urlSlug:urlLabel:urlIcon:ignoreCond
			($defaultFilter = $noneFilter = 'none'),
			($approveFilter = 'approved'), ($disapproveFilter = 'disapproved'),
			($banner1Filter = $this->getBanner1Details()[$K="dimension"]).':::'.!$isBannerCampaign,
			($banner2Filter = $this->getBanner2Details()[$K]).':::'.!$isBannerCampaign, 
			($banner3Filter = $this->getBanner3Details()[$K]).':::'.!$isBannerCampaign
		);
		
		
		///ORDER BY(oby)
		if($order = strtolower($this->ENGINE->get_global_var('get', $orderKey))){
		
			($order != $defaultOrder)? $this->ENGINE->set_global_var('ss', $orderSessKey, $order) :
			$this->ENGINE->unset_global_var('ss', $orderSessKey);
		
		}else
			$order = $this->ENGINE->get_global_var('ss', $orderSessKey);
		
		switch($order){
		
			case $hitsOrder: $orderBy = 'HITS DESC, TIME DESC'; break;
		
			default: $orderBy = 'TIME DESC';
		
		}
		
		if($isBannerCampaign)
			$filetoolarge = $this->ENGINE->get_large_upload_limit_error();
			
		/// FILTER
		if($filter = strtolower($this->ENGINE->get_global_var('get', $filterKey))){
			
			($filter != $defaultFilter)? $this->ENGINE->set_global_var('ss', $filterSessKey, $filter) :
			$this->ENGINE->unset_global_var('ss', $filterSessKey);
			
		}else
			$filter = $this->ENGINE->get_global_var('ss', $filterSessKey);
		
		switch($filter){
			
			case $banner1Filter: $filterCnd = " AND BANNER_TYPE = '".$this->getCampaignAdType1()."'"; break;
	
			case $banner2Filter: $filterCnd = " AND BANNER_TYPE = '".$this->getCampaignAdType2()."'"; break;
	
			case $banner3Filter: $filterCnd = " AND BANNER_TYPE = '".$this->getCampaignAdType3()."'"; break;
	
			case $approveFilter: $filterCnd = " AND APPROVAL_STATUS = '".$this->getApprovedAdState()."'"; break;
	
			case $disapproveFilter: $filterCnd = " AND APPROVAL_STATUS = '".$this->getDisapprovedAdState()."'"; break;
	
			default: $filterCnd = '';
			
		}	

		///ACTIVATE/DEACTIVATE NOTIFICATION/////
		if(isset($_POST[$ntfActKey]) || isset($_POST[$ntfDeactKey])){
			
			$this->ACCOUNT->updateUser($sessUsername, ' CAMPAIGN_NTF='.(isset($_POST[$ntfActKey])? 1 : 0));
			
			if($this->ENGINE->is_ajax())
				exit();
				
			
		}
					
		
		if($sessUsername){
							
			//////////GET THE USER CAMPAIGN STATUS//////

			///////////PDO QUERY///////////
			
			$sql =  "SELECT CAMPAIGN_NTF, ".$cstat_col.", ADS_CREDITS_AVAIL, ADS_CREDITS_USED, ADS_PREMIUM_PURSE FROM users WHERE USERNAME=?  LIMIT 1";
			$valArr = array($sessUsername);
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
			$row = $this->DBM->fetchRow($stmt);

			if(!empty($row)){
				
				$status = $row[$cstat_col];
				$ntfy = $row["CAMPAIGN_NTF"];
				$credits_avail = $row["ADS_CREDITS_AVAIL"];
				$credits_used = $row["ADS_CREDITS_USED"];
				$prmPurse = $row["ADS_PREMIUM_PURSE"];
				$ntfyHeading = '<h3 class="text-info inline-block">'.$this->SITE->getFA('fa-bell').'NOTIFICATIONS: </h3>';
				$ntfySliderId = 'ntfy-slider';
				$ntfyTxtScrn = 'ntfy-display';
				$ntfyFormSubmitName = $ntfy? $ntfDeactKey : $ntfActKey;
				$ntfyFormSubmitName4Tog = $ntfy? $ntfActKey : $ntfDeactKey;
				$ntfyBtnTitle = $ntfy? 'Deactivate' : 'Activate';
				$ntfyBtnTitle4Tog = $ntfy? 'Activate' : 'Deactivate';
				$ntfyDisTxt = $ntfy? 'ACTIVATED' : 'DEACTIVATED';
				$ntfyDisTxt4Tog = $ntfy? 'DEACTIVATED' : 'ACTIVATED';
				$ntfyTitle = $ntfyBtnTitle.' Campaign Notifications';
				$ntfyTitle4Tog = $ntfyBtnTitle4Tog.' Campaign Notifications';
				$ntfyCmnTogData = ' data-toggle="smartToggler" data-attr-only="true" ';
				$ntfyTogDatas = $ntfyCmnTogData.' data-id-targets="'.$ntfyTxtScrn.'" data-toggle-attr="class|btn-success btn-danger$title|'.$ntfyTitle4Tog.'$name|'.$ntfyFormSubmitName4Tog.'$val|'.$ntfyBtnTitle4Tog.'" data-target-attr="class|red green$text|'.$ntfyDisTxt4Tog.'" ';
				$ntfyTogDatasJsOnly = ' title="'.$ntfyTitle.'" data-ajax-submit="true" data-id-targets="'.$ntfySliderId.'" data-target-attr="checked|checked" '.$ntfyCmnTogData.' data-toggle-attr="title|'.$ntfyTitle4Tog.'" ';
				$ntfyFormDatas = ' data-submit-name="'.$ntfyFormSubmitName.'" data-alter-submit-name="'.$ntfyFormSubmitName.'|'.$ntfyFormSubmitName4Tog.'" data-retTypex="text" data-nospin="true" ';
				
				$campaignNotify = '<noscript class="inline-block bold">'.$ntfyHeading.'<span id="'.$ntfyTxtScrn.'" class="'.($ntfy? 'green' : 'red').'">'.$ntfyDisTxt.'</span> <form class="inline" method="post" action="/'.$this->pageSelf.'" '.$ntfyFormDatas.' ><input data-ajax-submit="true" class="btn btn-'.($ntfy? 'danger' : 'success').'" '.$ntfyTogDatas.' type="submit" title="'.$ntfyTitle.'" name="'.$ntfyFormSubmitName.'" value="'.$ntfyBtnTitle.'" /></form></noscript>'
				.'<form data-js-display-mode="inline-block" class="" method="post" action="/'.$this->pageSelf.'" '.$ntfyFormDatas.' >'.$ntfyHeading.$this->SITE->getHtmlComponent('switch-slider', array('wrapData'=>$ntfyTogDatasJsOnly, 'iWrapData'=>'style="top: -4px;"', 'fieldId'=>$ntfySliderId, 'on'=>$ntfy)).'</form>';
				
				list($rpUrl, $rpUrlToken) = $this->getPauseNResumeURL($this->rdr, true);
				$rpCfm = '<div class="alert alert-danger hide has-close-btn">
							<p>'.($status? '<span class="text-danger">Pausing your '.$campaignType.' campaigns will remove your '.$campaignType.' ads from all pages and sections where they are active</span><br/>Do You still wish to continue?' 
								: '<span class="text-primary">Please confirm that You want to resume your '.$campaignType.' campaigns</span>').'</p>
								<button class="btn btn-success campaign_stat" data-rpt="'.$rpUrlToken.'">YES</button>
								<button class="btn close-toggle">NO</button>
						</div>';
				
				$campaignStatus = '<span class="camp-stat-wrapper hash-focus" id="cs" >Campaign Status: <span class="'.($status? 'green' : 'red').'">'.($status? 'ACTIVE' : 'PAUSED').'</span></span> (<a href="'.$rpUrl.'"   class="links" data-toggle="smartToggler" >'.($status? 'Pause' : 'Resume').' '.ucwords($campaignType).' Campaign '.$this->SITE->getFA(($status? 'fa-pause red' : 'fa-play green'), array('title'=>($status? 'pause' : 'start or resume'))).'</a>)'.$rpCfm;
				
			}

			
			////TRACK AND DO AD PLACEMENT REQUESTS/////
			$this->doSinglePlacement();
			$this->doMultiPlacement();
			
			////TRACK AND DO ADS PLACEMENT REMOVAL REQUESTS//////
			$this->adPlacementMultiRemove();

			if($isBannerCampaign){
		
				////IF CHANGE OF BANNER IS SET///////////////////
				$responseMetaArr = $this->editAdBanner(); 
				$bannerDimensionSelectMenu = $responseMetaArr["bannerDimensionSelectMenu"];
				$uploadError = $responseMetaArr["uploadError"];
				$uploadLimitError = $responseMetaArr["uploadLimitError"];
		
				if(isset($responseMetaArr[$K="fid"]) && $responseMetaArr[$K]){
		
					$formId = $responseMetaArr[$K];
					$alertPer = $uploadError;
					$uploadError = '';
		
				}
				
				////IF CHANGE OF LANDING PAGE IS SET///////////////////
				$responseMetaArr = $this->editBannerAdLandPage(); 
				$error = $responseMetaArr["error"];	
			
				if(isset($responseMetaArr[$K="fid"]) && $responseMetaArr[$K]){
		
					$formId  = $responseMetaArr[$K];		
					$alertPer = $error;
					$error = '';
		
				}
		
			}else{
				
				////IF CHANGE OF TEXT AD DETAILS IS SET/////////
				$responseMetaArr = $this->editTextAdDetails();
				$updateAlert = $responseMetaArr["error"];
		
				if(isset($responseMetaArr[$K="fid"]) && $responseMetaArr[$K]){
		
					$formId  = $responseMetaArr[$K];		
					$alertPer = $updateAlert;
					$updateAlert = '';
		
				}
					
			}
			
			////CONTROL PER AD ALERT/////
			$alertUser .= !$formId? $alertPer : '';
			$alertUser .= $updateAlert.$uploadError.$uploadLimitError.$error;
			////////////POPULATE THE SESSION USER CAMPAIGNS////
					 
			//////PDO QUERY////////////
			
			$sql = "SELECT COUNT(*) FROM ".$campaignTable." WHERE USER_ID = ? ".$filterCnd;
			$valArr = array($sessUid);
			$totalRecords = $this->DBM->doSecuredQuery($sql, $valArr)->fetchColumn();
			
			////////////////POPULATE THE SECTION PLACEMENT DROP DOWN FOR ALL ADS PLACEMENTS OPTION///////////
			
			$categIdArr = VIRTUAL_CSID_ARR;
			
			$options=$catOpt=$homeOpt="";	
			///////////PDO QUERY/////////////////
			
			$sql = "SELECT ID, SECTION_NAME FROM sections ORDER BY SECTION_NAME ";
			$valArr = array();
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
			
			while($sectionRow = $this->DBM->fetchRow($stmt)){
				
				$sid = $sectionRow["ID"];
				$scatName = $sectionRow["SECTION_NAME"];
				$scatAdRate = $this->getAdRate(array("sid"=>$sid,"type"=>"cear","forOption"=>true,"forTextCampaign"=>$isTextCampaign));	
				
				if($sid == HOMEPAGE_SID)
					$homeOpt = '<option>'.$scatName.$scatAdRate.'</option>';
		
				elseif(in_array($sid, $categIdArr))
					$catOpt .= '<option>'.$scatName.$scatAdRate.'</option>';
		
				else
					$options .= '<option>'.$scatName.$scatAdRate.'</option>';
		
			}
			
			$homeOpt && $homeOpt = '<optgroup label="HOMEPAGE">'.$homeOpt.'</optgroup>';
			$catOpt && $catOpt = '<optgroup label="CATEGORIES">'.$catOpt.'</optgroup>';
			$options && $options = '<optgroup label="SECTIONS">'.$options.'</optgroup>';
			$availSection = $homeOpt.$catOpt.$options;	
			
			$delAllToggle = ' data-toggle="smartToggler" data-id-targets="del-all-modal" id="del-all-toggler" '; 
			$delAllToggleTgt =  ' id="del-all-modal" data-hide-toggler="del-all-toggler" '.$cmnToggleTgtDatas;
			
			if($totalRecords > 1)
					$gen_scat =	'
						<div id="del-all-hbase">
							<div class="cyan dsk-platform-dpn">(TIP: Hold <kbd>Ctrl</kbd> or <kbd>shift</kbd> to select multiple)</div>
							<div class="row cols-pad-all" >
								<div class="base-pad col-lg-w-5-pull" >					
									<form class="" method="post" action="/'.$this->pageSelf.'" id="mplc">
										'.(($formId == 'mplc')? $alertPer : '').'
										<div class="field-ctrl">
											<label class="text-uppercase">Place all your '.$campaignType.' Ads to selected sections:</label>
											<select class="field" name="campaign_location[]" multiple>
												 <option value="">--select a section--</option>
												 '.$availSection.'
											 </select>
										</div>
										<div class="field-ctrl">
											<button type="submit" class="form-btn" data-toggle="smartToggler" name="place_in_all_sections">place'.$this->SITE->getFA('fa-cloud-upload-alt', array('title'=>'upload')).'</button> 
											<div class="red modal-drop hide has-close-btn has-caret">
												<p><span class="text-warning">Place in Highlighted Sections</span><br/> ARE YOU SURE?</p>
												<button type="submit" class="btn btn-primary" name="place_in_all_sections">YES</button> 
												<button type="button" class="btn close-toggle">CLOSE</button>
											</div>
										</div>
									</form>
								</div>
								<div class="base-pad col-lg-w-5-pull">							
									<form class="" method="post" action="/'.$this->pageSelf.'" id="mrmv">
										'.(($formId == 'mrmv')? $alertPer : '').'
										 <div class="field-ctrl">
											<label class="text-uppercase red">Remove all your '.$campaignType.' Ads from selected sections
											:</label><br/>
											<select class="field" name="rmfloc_locs[]" multiple>
												<option>--highlight target sections--</option>
												'.$availSection.'
											</select>
										 </div>
										 <div class="field-ctrl">
											<label title="remove active ads from the selected section(s) and mark them as pending">
												Actives Only
												<span class="checkbox-iconic"><input type="checkbox" name="mrmv_ao" '.(isset($_POST["mrmv_ao"])? 'checked' : '').' class="checkbox" /><i aria-hidden="true"></i></span>
											</label>
										 </div>
										 <div class="field-ctrl">
											<button type="submit" class="form-btn btn-danger" data-toggle="smartToggler" name="rmfloc" title="Remove all your '.$campaignType.' ads from the selected sections">remove'.$this->SITE->getFA('fa-times', array('title'=>'remove')).'</button>
											<div class="red modal-drop hide has-close-btn has-caret">
												<p><span class="text-warning">Remove From Highlighted Sections</span><br/> ARE YOU SURE?</p>
												<button type="submit" class="btn btn-danger" name="rmfloc">YES</button>
												<button type="button" class="btn close-toggle">CLOSE</button>
											</div>
										</div>
									 </form>
								</div>
							</div>
							 <hr/><a role="button"  href="/delete-campaign?campaign='.$campaignType.'&ad='.($sessAll=SESS_ALL).'&_rdr='.$this->rdr.'" '.$delAllToggle.' class="form-btn btn-danger" title="Delete all '.$campaignType.' campaigns" >delete all'.$this->SITE->getFA('fa-trash', array('title'=>'delete all')).'</a>
							 <div '.$delAllToggleTgt.' >								
								<div class="red"><b/> WARNING!<hr/>'. strtoupper($sessUsername).'<br/> 
									<p>you are about to delete all your '.$campaignType.' campaigns 
										<br/>please confirm<br/>NOTE: you will no longer be able to access them once deleted<br/>
									</p>
									<input type="button" data-campaign-id="'.$sessAll.'" data-campaign="'.$campaignType.'" class="btn btn-sm btn-danger confirm-camp-del" value="OK" /> 								
									<input class="btn btn-sm close-toggle" type="button" value="CLOSE" /></b>
								</div>
							</div>				 
						</div><hr/>';

			

			if($totalRecords){
			
				/**********CREATE THE PAGINATION*************/
				$urlhash='ptab';
				$paginationArr = $this->SITE->paginationHandler(array('totalRec'=>$totalRecords,'url'=>$pageUrl,'hash'=>$urlhash));						
				$pagination = $paginationArr["pagination"];
				$totalPage = $paginationArr["totalPage"];
				$perPage = $paginationArr["perPage"];
				$startIndex = $paginationArr["startIndex"];
				$pageId = $paginationArr["pageId"];

				//////////////////////END OF PAGINATION/////////								

				//////POPULATE EACH CAMPAIGN/////////							

				///////////PDO QUERY///////////
				$sql = "SELECT c.*".$this->getAdHitsNClicksSubQry('c.ID', '?')." FROM ".$campaignTable." c WHERE USER_ID = ? ".$filterCnd." ORDER BY ".$orderBy." LIMIT ".$startIndex.",".$perPage;
				$valArr = array($campaignType, $campaignType, $sessUid);
				$stmtx = $this->DBM->doSecuredQuery($sql, $valArr);
												
				while($rowx = $this->DBM->fetchRow($stmtx)){				
					
					//////////CLEAR THE LOOP VARIABLES TO AVOID ACCUMULATING TO THE NEXT ROW///////////////////						
					$bannerDimension=$bannerType=''; //DEFAULT TO TEXT														
					
					if($isBannerCampaign){
						
						$bannerType = $rowx["BANNER_TYPE"];
						$bannerDimension = $this->getBannerDetails($bannerType);
					}

					$adId = $rowx["ID"];
					$adIdEnc = $this->INT_HASHER->encode($adId);
					$idHash = '#'.$adIdEnc;
					$placementsArr = $this->adPlacementHandler(array('adId'=>$adId, 'action'=>'get', 'fetchAll'=>true));													
							
					////////POPULATE THE SECTION PLACEMENT DROP DOWN  OPTION FOR INDIVIDUAL AD PLACEMENTS////////

					$options=$catOpt=$homeOpt="";	////IMPORTANT (ALSO USED ABOVE)	
					
					///////////PDO QUERY////////////////////////////////////	
		
					$sql = "SELECT ID, SECTION_NAME FROM sections ORDER BY SECTION_NAME ";
					$valArr = array();
					$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
					
					while($sectionRow = $this->DBM->fetchRow($stmt)){					
						
						$sid = $sectionRow["ID"];
						$scatName = $sectionRow["SECTION_NAME"];
						$scatAdRate = $this->getAdRate(array("sid"=>$sid, "type"=>"cear", "forOption"=>true, "forTextCampaign"=>$isTextCampaign, "bannerType"=>$bannerType));	
						
						//IF AD IS ALREADY PLACED IN THE SECTION, THEN SKIP IT				
						if($this->adPlacementHandler(array('adId'=>$adId, 'sid'=>$sid, 'action'=>'check')))
							continue;										
						
						elseif($sid == HOMEPAGE_SID)
							$homeOpt = '<option>'.$scatName.$scatAdRate.'</option>';					
						
						elseif(in_array($sid, $categIdArr))
							$catOpt .= '<option>'.$scatName.$scatAdRate.'</option>';					
						
						else
							$options .= '<option>'.$scatName.$scatAdRate.'</option>';
						
					}
					
					$homeOpt && $homeOpt = '<optgroup label="HOMEPAGE">'.$homeOpt.'</optgroup>';
					$catOpt && $catOpt = '<optgroup label="CATEGORIES">'.$catOpt.'</optgroup>';
					$options && $options = '<optgroup label="SECTIONS">'.$options.'</optgroup>';
					$availSection = $homeOpt.$catOpt.$options;
								
					/////DISPLAY PLACEMENT LOCATIONS AND STATUS/////
					
					//////VERY IMPORTANT////////
					$activePlcCount=$pendingPlcCount=0;
					$pendingPlacements=$activePlacements=$sidActive=$sidPending=$sidActiveGrpRmvLink=$sidPendingGrpRmvLink="";
			
					if(!empty($placementsArr)){
						
						foreach($placementsArr as $oldPlacementsArr){								
				
							////ISOLATE ACTIVELY PLACED  FROM PENDING PLACEMENTS/////									
							$sid = $oldPlacementsArr["SECTION_ID"];
							$timePlacedPending = $oldPlacementsArr["TIME"];
				
							if(!$sid)
								continue;
				
							$sectionPlaced = $this->SITE->sectionIdToggle($sid);
							$scatTerm = in_array($sid, $categIdArr)? ' Category ' : ' Section ';
							//$sectionPlacedSanitized = $this->ENGINE->sanitize_slug($sectionPlaced);
							
							/////////CHECK IF THE AD IS ACTIVE IN THE SECTION IT WAS PLACED///////////
							 
							$adType = $isBannerCampaign? $bannerType : $this->getCampaignAdType4();
							
							///////////PDO QUERY/////////
							$sql = "SELECT ID, ACTIVE_TIME FROM active_section_ads WHERE (SECTION_ID = ? AND AD_ID = ? AND AD_TYPE = ? AND ACTIVE_TIME !=0) LIMIT 1";
							$valArr = array($sid, $adId, $adType);
							$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
							$row = $this->DBM->fetchRow($stmt);
							$isActive = !empty($row);
							$timePlacedActive = $isActive? $row["ACTIVE_TIME"] : 0;
							
							//////PLACEMENT REMOVAL METAS///////
							$plcRemMetaArr = array();
							$plcRemMetaArr['sid'] = $sid; 
							$plcRemMetaArr['scatPlaced'] = $sectionPlaced; 
							$plcRemMetaArr['adId'] = $adId; 
							$plcRemMetaArr['adIdEnc'] = $adIdEnc;
							$plcRemMetaArr['activeOnly'] = false;
							$plcRemMetaArr['rdr'] = $this->rdr; 
							$plcRemMetaArr['idHash'] = $idHash; 
							$plcRemMetaArr['scatTerm'] = $scatTerm;
							$plcRemMetaArr['time'] = $timePlacedPending;
				 
							////////////////////////
							if($isActive){
				
								$plcRemMetaArr['activeOnly'] = true; 
								$plcRemMetaArr['time'] = $timePlacedActive; 
								$activePlcCount++;
								$sidActive .= $sid.'_';															
								
								$activePlacements .= $this->getPlacementRemovalBtn($plcRemMetaArr);
								
								continue;////VERY IMPORTANT////
								
							}
							
							$pendingPlcCount++;
							$sidPending .= $sid.'_';
			
							if($sectionPlaced){
								
								$pendingPlacements .= $this->getPlacementRemovalBtn($plcRemMetaArr);
								
							}																										
			
						}
						
						$sidActive = trim($sidActive, "_");
						$sidPending = trim($sidPending, "_");
						
						if($sidActive && $activePlcCount > 1){
				
							$plcRemMetaArr["grpSid"] = $sidActive;
							$plcRemMetaArr["activeOnly"] = true;
							$sidActiveGrpRmvLink = $this->getPlacementRemovalGrpBtn($plcRemMetaArr);
				
						}
						
						if($sidPending && $pendingPlcCount > 1){
				
							$plcRemMetaArr["grpSid"] = $sidPending;
							$plcRemMetaArr["activeOnly"] = false;
							$sidPendingGrpRmvLink = $this->getPlacementRemovalGrpBtn($plcRemMetaArr);
				
						}				
						
						//Trim off the trailing comma added by calling getPlacementRemovalBtn() => ',</div> '

						if($pendingPlacements)
							$pendingPlacements = '<div class="aplc-base hr-divider no-bg"><b><span class="red">('.$pendingPlcCount.') PENDING</span> PLACEMENTS:</b> '.substr($pendingPlacements, 0, -8).'</div>'.$sidPendingGrpRmvLink.'</div>';
						
						if($activePlacements)	
							$activePlacements = '<div class="aplc-base hr-divider"><b><span class="green">('.$activePlcCount.') ACTIVE</span> IN:</b> '.substr($activePlacements, 0, -8).'</div>'.$sidActiveGrpRmvLink.'</div>';
						
					
					}

					
					$approvalStatus = $rowx["APPROVAL_STATUS"];
					
					$apprInfoBtnCls = 'success';

					switch($approvalStatus){
						
						case $this->getApprovedAdState(): $approvalStatus = 'APPROVED'; $apprCss = 'green';  $apprFav = 'fa-check'; $apprTitle = 'Congrats! This campaign has been approved'; break;
				
						case $this->getPendingAdState(): $approvalStatus = 'PENDING'; $apprInfoBtnCls = 'info'; $apprCss = 'cyan';  $apprFav = 'fa-clock'; $apprTitle = 'This campaign is under review and awaiting approval'; break;
				
						case $this->getDisapprovedAdState(): $approvalStatus = 'DISAPPROVED'; $apprInfoBtnCls = 'danger'; $apprCss = 'red';  $apprFav = 'fa-times';  $apprTitle = 'Oops! This campaign has been disapproved because it violated our ad policy'; break;
				
						default: $approvalStatus = $apprCss = '';
						
					}


					$apprInfoBtn = '<small class="pointer lblack" data-toggle="smartToggler" title="click to learn more">'.$this->FA_infoCircle.'</small>
									<div class="alert alert-'.$apprInfoBtnCls.' hide has-close-btn font-default">'.$apprTitle.'</div>';
					
					$approvalStatus = '<div class="base-tb-mg prime"><b>STATUS: <span class="'.$apprCss.'" titleX="'.$apprTitle.'" data-field-tip="true" data-tip-loader="'.($K='_'.$adId.'-cmpappr').'" data-tip-w="180" data-tip-xoffset="10">'.$approvalStatus.$this->SITE->getFA($apprFav).'</span><span class="hide" id="'.$K.'">'.$apprTitle.'</span></b>'.$apprInfoBtn.'</div>';
									
					$hits = $rowx["HITS"];
					$clicks = $rowx["CLICKS"];
					$rawLinkTxt = $isTextCampaign? $rowx["LINK_TEXT"] : '';
					$dateUploaded = $this->ENGINE->time_ago($rowx["TIME"]);
					$rawUrl = $rowx["AD_URL"];
					$url = $this->ENGINE->add_http_protocol($rawUrl);
									
					$cntToggle = ' data-toggle="smartToggler" data-id-targets="modal-'.$adIdEnc.'" id="toggler-'.$adIdEnc.'" '; 
					$cntToggleTgt =  ' id="modal-'.$adIdEnc.'" data-hide-toggler="toggler-'.$adIdEnc.'" '.$cmnToggleTgtDatas;
					$lnkToggle = ' data-toggle="smartToggler" data-id-targets="lnk-modal-'.$adIdEnc.'" id="lnk-toggler-'.$adIdEnc.'" '; 				
					$lnkToggleTgt =  ' id="lnk-modal-'.$adIdEnc.'" data-hide-toggler="lnk-toggler-'.$adIdEnc.'" '.$cmnToggleTgtDatas;
					$delToggle = ' data-toggle="smartToggler" data-id-targets="del-modal-'.$adIdEnc.'" id="del-toggler-'.$adIdEnc.'" '; 				
					$delToggleTgt =  ' id="del-modal-'.$adIdEnc.'" data-hide-toggler="del-toggler-'.$adIdEnc.'" '.$cmnToggleTgtDatas;
					$landPageEditUrl = '/'.$this->getMeta('edit_slug', array('adId' => $adIdEnc, 'type' => $isBannerCampaign? 'banner-lp' : 'text'));

					$campaignAccArr[] = '
					<div class="campaign-base '.(($totalRecords > 1)? 'col-lg-w-5-pull' : '').'">
						<div class="panel hash-focus" id="'.$adIdEnc.'">
							<div class="panel-head page-title bg-dcyan">
								<header class="">
									<div class="cyan clear">
										<span class="pull-mob-l pull-dsk-l"><span class="'.($K='pill-follower bg-limex').'"><label class="flab">ID: </label>'.$adIdEnc.'</span></span>
										<span class="pull-mob-l pull-dsk-r"><span class="'.$K.'"><label class="flab">CLICKS: </label>'.$this->ENGINE->format_number($clicks).'</span></span>
										<span class="pull-mob-l pull-dsk-r"><span class="'.$K.'"><label class="flab">HITS: </label>'.$this->ENGINE->format_number($hits).'</span></span>
									</div>
									<div class="base-t-mg"><span class="dwhite"><label class="dwhite flab">UPLOADED: </label>'.$dateUploaded.'</span></div>
								</header>
							</div>
							<div class="panel-body ad-campaign">
								<div class=""><a href="/ad-traffic-report/'.$campaignType.'/'.$adIdEnc.'" role="button" class="btn btn-info" title="View the report of this Ad" >Report'.$this->SITE->getFA('fa-briefcase', array('title'=>'report')).'</a></div>
								<br/>'.(($formId == $adIdEnc)? $alertPer : "")
								.($isBannerCampaign? '
									<div class="ad-disp-base">
										<div class="flab">BANNER('.$bannerDimension.'): </div><div class="widget banner-widget '.$bannerType.'" ><img alt="'.$rawUrl.':ad banner" title="'.$rowx["AD_IMAGE"].'" class="img-responsive" src="'.$this->mediaRootBanner.$rowx["AD_IMAGE"].'"/></div><div><a role="button" href="/'.$this->getMeta('edit_slug', array('adId' => $adIdEnc, 'type' => 'banner')).'?_rdr='.$this->rdr.'" '.$cntToggle.' class="btn btn-warning btn-xs" title="Change this banner" >Edit'.$this->SITE->getFA('fa-edit', array('title'=>'Edit')).'</a></div>
										<div '.$cntToggleTgt.'>							
											<form class="" method="post" action="/'.$this->pageSelf.'#'.$adIdEnc.'"  enctype="multipart/form-data">
												<div class="field-ctrl">
													<label>BANNER SIZE: <span class="red">(in pixels)</span></label>
													'.$bannerDimensionSelectMenu.'
												</div>								
												<div class="field-ctrl">
													<label>UPLOAD YOUR NEW BANNER:<br/>'.$this->getMeta('adbanner_upload_tip').'</label>				
													<input class="field upload-field" type="file" name="ads_image" required="required"  />					
													<input type="hidden" name="ad_id"  value="'.$adIdEnc.'" />
												</div>'.
												$this->getAutoInstantApprovalBtn().
												$this->getCampaignNote('re-approval-short').'
												<div class="field-ctrl">									
													<div class="btn-ctrl">										
														<input type="submit" class="form-btn btn-success" name="change_banner"  value="change"  />
													</div>
												</div>							
											</form>
										</div>
									</div>' :
									($isTextCampaign? '
										<label class="form-label">LINK TEXT:</label> '.$rawLinkTxt.' <a role="button" href="'.$landPageEditUrl.'?_rdr='.$this->rdr.'#tl" '.$cntToggle.' class="btn btn-warning btn-xs" title="Change this Link Description Text" >Edit'.$this->SITE->getFA('fa-edit', array('title'=>'Edit')).'</a>						
										<div '.$cntToggleTgt.'>						
											<form class="" method="post" action="/'.$this->pageSelf.'#'.$adIdEnc.'">
												<div class="field-ctrl">
													<label>LINK TEXT:<br/>'.$this->getMeta().'</label>								
													<textarea name="linkText" maxLength="'.$campaignMetas["maxTextAdLink"].'" data-field-count="true" class="field">'.$rawLinkTxt.'</textarea>
												</div>'.
												$this->getAutoInstantApprovalBtn().
												$this->getCampaignNote('re-approval-short').'
												<div class="field-ctrl">								
													<div class="btn-ctrl">
														<input type="hidden" name="ad_id" value="'.$adIdEnc.'" />
														<input type="submit" class="form-btn btn-success" name="update_details" value="change" />
													</div>
												</div>
											</form>
										</div>'
										
										: ''					
									)
								)
								.'<br/>
								
								<label class="form-label">LANDING PAGE URL: </label>'.$url.' <a role="button" href="'.$landPageEditUrl.'?_rdr='.$this->rdr.$lpHash.'" '.$lnkToggle.' class="btn btn-warning btn-xs" title="Edit this landing page" >Edit'.$this->SITE->getFA('fa-edit', array('title'=>'Edit')).'</a>
								<div '.$lnkToggleTgt.'>						
									<form class="" method="post" action="/'.$this->pageSelf.'#'.$adIdEnc.'">
										<div class="field-ctrl">
											<label>YOUR NEW LANDING PAGE URL:<br/>'.$this->getMeta().'</label>
											<input class="field" type="text" name="landing_page" placeholder="Enter here the new landing page url" value="'.$rawUrl.'" />							
											<div class="btn-ctrl">
												<input type="hidden" name="ad_id"  value="'.$adIdEnc.'" />
												<input type="submit" class="form-btn btn-success" name="'.$landpage_fs_name.'"  value="change"  />
											</div>
										</div>
									</form>
								</div>
								
								'.$approvalStatus.$activePlacements.$pendingPlacements.'											
								
								<form class="" method="post" action="/'.$this->pageSelf.'">
									<div class="field-ctrl">
										 <label>PLACE ON SECTION:</label>
										 <select class="field" name="campaign_location">
											<option value="">--select a section--</option>
											'.$availSection.'															
										 </select>
									 </div>
									 <div class="field-ctrl">
										<input type="hidden" name="ad_id"  value="'.$adIdEnc.'" />
										<button type="submit" class="form-btn" name="place_in_section">place'.$this->SITE->getFA('fa-cloud-upload-alt', array('title'=>'upload')).'</button>
									 </div>
								 </form><br/>
								 <a role="button"  href="/delete-campaign?campaign='.$campaignType.'&ad='.$adIdEnc.'&_rdr='.$this->rdr.$idHash.'"  '.$delToggle.'  class="form-btn btn-danger" data-campaign-id="'.$adIdEnc.'" data-campaign="'.$campaignType.'"  title="Delete this ad campaign" >delete'.$this->SITE->getFA('fa-trash', array('title'=>'delete')).'</a>
								<div '.$delToggleTgt.' >								
									<div class="red"><b/> WARNING!<hr/>'. strtoupper($sessUsername).'<br/> 
										<p>you are about to delete this campaign (<b class="cyan">'.$adIdEnc.'</b>)
											<br/>please confirm<br/>NOTE: you will no longer be able to access it once deleted
										</p>
										<input type="button" data-campaign-id="'.$adIdEnc.'" data-campaign="'.$campaignType.'" class="btn btn-sm btn-danger confirm-camp-del" value="OK" /> 							
										<input class="btn btn-sm close-toggle" type="button" value="CLOSE" /></b>
									</div>
								</div>					
							</div>					
						</div>
					</div>';
						
								
				}

				//Arrange the ads to display maximum of 2 per row
				if($campaignAccArrCount = count($campaignAccArr)){
					
					for($i = 0; $i < $campaignAccArrCount; $i += 2){

						$twinIndex = ($i + 1);

						$allCampaign .= '<div class="row cols-pad-all">'.$campaignAccArr[$i].(isset($campaignAccArr[$twinIndex])? $campaignAccArr[$twinIndex] : '').'</div>';

					}

				}				
					
							
			}else
				$alertUser .= '<span class="alert alert-danger">Sorry! you have no '.$campaignType.' campaigns'.($filter? ' matching that filter' : ' yet<br/> <a href="/'.$this->getMeta('upload_slug', array('type' => ($isBannerCampaign? 'banner' : 'text'))).'" class="links">click here to '.($isBannerCampaign? 'upload' : 'start').'</a> '.($isBannerCampaign? ' a banner and start a' : ' a text').' campaign').'</span>';
								
		}else
			$notLogged = $this->notLoggedMsg;
		
		$subNav="";
		$subNav .= ($isBannerCampaign? '<a href="/'.$this->getMeta('upload_slug', array('type' => 'banner')).'" class="links" title="upload new ad banner" >Upload New Banner Ad</a>' : '<a href="/'.$this->getMeta('upload_slug', array('type' => 'text')).'" class="links" title="upload new text ad" >Upload New Text Ad</a>').' | <a href="/ad-credit-history" class="links" title="see your ads campaign credit purchase histories" >Credit Records</a> | ';

		if($campaignStatus && $allCampaign){

			$subNav .= $this->getMeta('traffic_export_link').' | ';
			$subNav .= '<a href="/ad-billing-report/'.$campaignType.'/none/none/descending" class="links" title="Get billing report for your campaigns" >Billing Report'.$this->SITE->getFA('fa-dollar-sign', array('title'=>'Billing Report')).'</a> | '. $campaignStatus;  

		}	
		
		$navTab = '<nav class="nav-base">
						<ul class="nav nav-tabs justified justified-bom">
							<li '.($isBannerCampaign? 'class="active"' : '').'><a href="/ads-campaign/banner-campaign" class="links" >Banner Campaign</a></li>
							<li '.($isTextCampaign? 'class="active"' : '').' ><a href="/ads-campaign/text-campaign" class="links">Text Campaign</a></li>
						</ul>
					</nav>';
		
		$filterNav = $this->SITE->buildSortLinks(array(
			'baseUrl' => $pageSelfFlt, 'pageId' => '', 'navExtCls' => 'base-xs',
			'activeOrder' => $order, 'orderList' => $orderList, 'orderKey' => $orderKey,
			'activeFilter' => $filter, 'filterList' => $filterList, 'filterKey' => $filterKey,
			'defaultOrder' => $defaultOrder, 'defaultFilter' => $defaultFilter, 
			'orderGlobLabel' => 'Sort by', 'filterGlobLabel' => 'Filter'
		));
				
		$header = '<div class="single-base blend-top">								
					<h1 class="">ADS CAMPAIGN:</h1><hr class="no-bm"/>
					<div class="row cols-pad">
						<div class="col-lg-w-5-pull">
							<div class="hr-dividers no-bg">
								<div class="base-lr-pad">
									Please See our estimated <a href="/estimated-ad-rates" class="links">Ad Rates</a> for advertising on each sections of this community.<br/>
									See also <a href="/ads-campaign#hta" class="links">how to run a campaign</a> and <a href="/policies/ads" class="links">our Ad Policies</a>.<br/>
									To purchase advertising credits, please choose a payment method below. <b class="prime">Note: The minimum purchasable campaign credit is '.($currencySymbol = $campaignMetas["currencySymbol"]).$this->ENGINE->format_number($campaignMetas["minAdDeposit"], 0, false).$campaignMetas["currency"].'</b>
									'.$this->getMeta("credit_purchase_btn").'
									<br/>
									<b class="text-success">Campaign credits equivalent to the sum paid will be automatically applied to your account once payment is successfully completed</b>.<br/>
									<br/>Please feel free to reach out to us should you run into any difficulties.
									<br/>You can call or text our hot lines below:<br/><b class="sky-blue">'.SITE_HOT_LINES.'</b>
									<br/>or chat us at <b>'.SITE_WHATSAPP_URL.'</b>
								</div>
								<div>
									<div data-field-tip="true" data-tip-w="300" data-tip-loader="'.($K='_69cmpntfy').'">
										'.$campaignNotify.'
										<span class="hide" id="'.$K.'">When this option is activated, our mail dispatcher will send notifications regarding your campaigns to your email address</span>
									</div>
								</div>								
							</div>
						</div>
					
						<div class="col-lg-w-5-pull">
							<div class="camp-bank hr-dividers">
								<div class="'.(($credits_avail > $campaignMetas["minAdPlaceCredit"])? 'green' : 'red').'">
									CREDITS AVAILABLE: '.$currencySymbol.$this->ENGINE->format_number($credits_avail, 2, false).($adCreditSuffix = $campaignMetas["adCreditSuffix"]).'
								</div>
								<div class="'.($prmPurse? 'gold' : 'red').'">
									<b class="bg-gold">'.$this->FA_shield.'</b>
									PREMIUM PURSE: '.$currencySymbol.$this->ENGINE->format_number($prmPurse, 2, false).$adCreditSuffix.'
									<small class="pointer lblack" data-toggle="smartToggler" title="click to learn more">'.$this->FA_infoCircle.'</small>
									<div class="alert alert-info hide has-close-btn font-default">
										If the discount on a section is labeled as premium, it means that discount will only apply to you if your premium purse is not empty.
										Consequently, your premium purse will drop each time it\'s used to apply a premium discount.
										<div class="prime-2">With your premium purse you also get access to export the expanded version of your ad traffic report.</div>
										'.$this->getCampaignNote('premium-discount').'
									</div>
								</div>
								<div class="">
									'.$this->getEstimatedCampaignCost($sessUid).'
								</div>
								<div class="prime">
									CREDITS USED: <span id="cubank">'.$currencySymbol.$this->ENGINE->format_number($credits_used, 2, false).'</span>'.$adCreditSuffix .'
									<small>(<a href="/reset-cubank?_rdr='.$this->rdr.'" class="links" data-toggle="smartToggler" data-id-targets="cuc_reset" title="Reset AD CREDITS USED to Zero" >Reset</a>)</small>
									<div class="modal-drop hide has-close-btn has-caret red" id="cuc_reset">
										<p> ARE YOU SURE YOU WANT TO RESET?</p>
										<button class="close-toggle reset-cubank btn btn-danger" title="Reset AD CREDITS USED to Zero" >RESET</button>
										<button type="button" class="btn close-toggle">CLOSE</button>			
									</div>
								</div>
								<div class="font-default text-info">
									<h3>IMPORTANT NOTES:</h3>
									'.$this->getCampaignNote().'
								</div>
							</div>
						</div>
					</div>
				</div>';
		$subNav = '<div class="base-lr-pad">'.$subNav.'</div>';
		$html = ($sessUsername? '
					<div class="base-ctrl">'.$header.'</div>' : ''
				).'
				<div class="single-base blend-top">
					<div class="base-ctrl base-t-pad align-c">
					'.(isset($notLogged)?  $notLogged : '' ).'

					'.($sessUsername?	
						$subNav.$navTab.
						'<h2 class="page-title pan bg-orange" id="cfhd">'.strtoupper($campaignType).' CAMPAIGN(<span id="tc-count">'.$this->countCampaign($sessUid, $filterCnd).'</span>)</h2>
						'.$filterNav
						.((isset($pagination) && $pagination)? $pagination.'<div class="cpop" id="del-all-hbase">(page <span class="cyan">'.$pageId.'</span>  of '.$totalPage.')</div>' : '')
						
						.($sessAlert? $sessAlert : '')										
						.(isset($alertUser)? $alertUser : '')										

						.'<div class="">'	
							.(isset($allCampaign)?  $allCampaign : '')
						.'</div>'.								
								(isset($gen_scat)? '<div class="hr-divider">'.$gen_scat.'</div>' : '')
								 .((isset($pagination) && $pagination)?  $pagination : '')				
								.$subNav.$navTab					
						: ''
					).'
					</div>
				</div>';		
		
		return $html;

		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*** Page request handlers ***/
	
	
	
	
	
	/* Method for handling ad credits used reset request */
	public function processCreditsUsedReset(){
		
		if($sessUsername = $this->SESS->getUsername()){
				
			$this->ACCOUNT->updateUser($sessUsername, "ADS_CREDITS_USED = 0 ");
										
		}
		
		header("Location:".$this->getReturnUrl());
		exit();
		
	}
	
	
	
	
	
	
	
	/* Method for handling campaign clicks/traffic  tracking request */
	public function processCampaignTrafficTracking(){
		
		if(isset($_GET["ad_id"]) && isset($_GET["loc"])){				
			
			if(isset($_GET[$K="campaign"]))
				$campaign = $this->ENGINE->sanitize_user_input($_GET[$K]);
			
			if(isset($_GET[$K="loc"]))
				$location = $this->ENGINE->sanitize_number($_GET[$K]);
			
			if(isset($_GET[$K="ad_id"])){
				
				$adIdEnc = $_GET[$K];
				$adId = $this->ENGINE->sanitize_number($this->INT_HASHER->decode($adIdEnc));
				
			}
			
			if($this->validateCampaignType($campaign) && $location && $adId && ($sessUid = $this->SESS->getUserId())){
				
				$this->setCampaignType($campaign);
				$campaignTable = $this->getCampaignTable();
				$adRptTable = ' ad_traffic_reports ';
				
								
				///////////PDO QUERY///////
				
				$sql =  "SELECT AD_URL FROM ".$campaignTable." WHERE ID=? LIMIT 1";
				$valArr = array($adId);
				$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
				$row = $this->DBM->fetchRow($stmt);	

				if(!empty($row)){	
									
					$ip = $this->ENGINE->get_ip();
																		
					/*
					if(!$sessUid){
						///////////PDO QUERY///////////
						
						$sql =  "SELECT ID FROM  ".$adRptTable."  WHERE (AD_ID = ? AND CAMPAIGN_TYPE=? AND IP=?) LIMIT 1";
						$valArr = array($adId, $campaign, $ip);
						
					}else{
						///////////PDO QUERY///////////
						
						$sql =  "SELECT ID FROM  ".$adRptTable."  WHERE (AD_ID = ? AND CAMPAIGN_TYPE=? AND SOURCE_USER_ID = ?) LIMIT 1";
						$valArr = array($adId, $campaign, $sessUid);
						
					}			
					
					$ipExist = $this->DBM->doSecuredQuery($sql, $valArr)->fetchColumn();
					*/										
					
					$landPage = $row["AD_URL"];									
											
					//if(!$ipExist){									
											
						///////////PDO QUERY////////
					
						$sql =  "INSERT INTO  ".$adRptTable." (AD_ID, CAMPAIGN_TYPE, SOURCE_SECTION_ID, IP, SOURCE_USER_ID) VALUES(?,?,?,?,?)";
						$valArr = array($adId, $campaign, $location, $ip, $sessUid);	
						$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
						
					//}	
					
					//header("Refresh:3;url=".$landPage);
					header("Location:".$landPage);
					exit();	
			
				}
						
			}
													
		}
		
		header("Location:".$this->getReturnUrl());
		exit();
		
		
	}
	
	
	
	
	
	
	
	
	/* Method for handling campaign pause/resume request */
	public function processPauseOrResume(){
		
		$rpt=$campaignStatusType=$status="";
		
		if(isset($_GET[$K="rpt"]))
			$rpt = $_GET[$K];
		
		if(isset($_POST[$K]))
			$rpt = $_POST[$K];
		
		if(isset($_POST[$K="rdr"]))
			$rdr = $_POST[$K];

		if(($sessUid = $this->SESS->getUserId()) && ($sessUsername = $this->SESS->getUsername()) && $rpt){
				
			$campaignArr = explode('_', $this->ENGINE->sanitize_user_input($rpt));
			
			if(isset($campaignArr[1]) && $this->validateCampaignType(($campaign = $campaignArr[1]))){
				
				$campaignStatusType = strtoupper($campaign).'_CAMPAIGN_STATUS';
				
				///////////PDO QUERY////
					
				$sql =  "SELECT ".$campaignStatusType." FROM users WHERE USERNAME=? LIMIT 1";
				$valArr = array($sessUsername);	
				
				$status = $this->DBM->doSecuredQuery($sql, $valArr)->fetchColumn();
				
				$status = !$status? 1 /*RESUME*/ : 0 /*PAUSE*/;
				
				$cols = $campaignStatusType."=? ";	
				$this->ACCOUNT->updateUser($sessUsername, $cols, array($status));
						
				if(!$status){//IF PAUSED
					
					///IF A USER PAUSES THEIR CAMPAIGN THEN REMOVE THEIR ADS FROM ACTIVES
					
					try{
						
						// Run campaign pause active ads removal transaction
						$this->DBM->beginTransaction();
					
						$this->removeFromActiveAdSlots(array("uid"=>$sessUid));
					
						// If we arrived here then our campaign pause active ads removal transaction was a success, we simply end the transaction
						$this->DBM->endTransaction();
						
					}catch(Throwable $e){
						
						// Rollback if active campaign pause active ads removal transaction fails
						$this->DBM->cancelTransaction();
						
					}
				
			   }
			   
		   }

		}
		
		if(!$this->ENGINE->is_ajax()){	
			
			header("Location:".$this->getReturnUrl());
			exit();
			
		}

		
	}
	
	
	
	
	
	
	
	/* Method for handling section ad removal request */
	public function processSectionAdRemove(){
		
		
			$section=$campaignId=$campaign="";			

			if($sessUid = $this->SESS->getUserId()){

				if(isset($_POST[$K="ad"])  || isset($_GET[$K])){
					
					if(isset($_POST[$K]))
						$campaignId = $_POST[$K];

					if(isset($_GET[$K]))
						$campaignId = $_GET[$K];

					if(isset($_POST[$K="section"]))
						$section = $_POST[$K];

					if(isset($_GET[$K]))
						$section = $_GET[$K];
					
					if(isset($_POST[$K="campaign"]))
						$campaign = $_POST[$K];

					if(isset($_GET[$K]))
						$campaign = $_GET[$K];
					
					$activeOnly = false;
					
					if(isset($_POST[$K="active_only"]))
						$activeOnly = (strtolower($_POST[$K]) == 'true');

					if(isset($_GET[$K]))
						$activeOnly = (strtolower($_GET[$K]) == 'true');
					
					$campaign = strtolower($this->ENGINE->sanitize_user_input($campaign));
					$isAll = (strtolower($campaignId) == SESS_ALL);

					$campaignId = $this->INT_HASHER->decode($campaignId);
						
					if($this->validateCampaignType($campaign)){
						
						$this->setCampaignType($campaign);
						$sidArr = explode("_", $section);
						
						if($this->ENGINE->sanitize_number($section)){
							
							try{
								
								// Run section ad removal transaction
								$this->DBM->beginTransaction();
									
								if($isAll){
									
									if(!$activeOnly)
										$this->adPlacementHandler(array('uid'=>$sessUid, 'sid'=>$sidArr, 'action'=>'del-by-uid'));
									
									$this->removeFromActiveAdSlots(array("uid"=>$sessUid, "sid"=>$sidArr));
									
								}else{
									
									if(!$activeOnly)
										$this->adPlacementHandler(array('adId'=>$campaignId, 'sid'=>$sidArr, 'action'=>'del'));
									
									$this->removeFromActiveAdSlots(array("adId"=>$campaignId, "sid"=>$sidArr));
									
								}
								
								// If we arrived here then our section ad removal transaction was a success, we simply end the transaction
								$this->DBM->endTransaction();
								
							}catch(Throwable $e){
								
								// Rollback if active section ad removal transaction fails
								$this->DBM->cancelTransaction();
								
							}	
						
						}
							
						
					}
				
				}

			}

			//////////REDIRECT FOR NON JS DEVICES/////
			if($rdrAlt = $this->getReturnUrl()){

				$this->ENGINE->set_global_var('ss', 'SESS_ALERT', '<span class="alert alert-success" '._TIMED_FADE_OUT.' data-click-to-hide="true">Done!</span>');
				header("Location:".$rdrAlt);	

			}elseif(!$this->ENGINE->is_ajax())	
				header("Location:".$rdrAlt);

			exit();
		
		
	}
	
	
	
	
	
	
	
	
	/* Method for handling campaign data export request */
	public function processCampaignDataExport(){
	
		$exportItem = isset($_GET[$K="export_item"])? $this->ENGINE->sanitize_user_input($_GET[$K], array('lowercase' => true)) : '';
		$exportType = isset($_GET[$K="export_type"])? $this->ENGINE->sanitize_user_input($_GET[$K], array('lowercase' => true)) : '';
		$adIdEnc = isset($_GET[$K="item_id"])? $_GET[$K] : '';
		$adId = $this->ENGINE->sanitize_number($this->INT_HASHER->decode($adIdEnc));
		$isBill = ($exportItem == 'billing');
		$isTraffic = ($exportItem == 'traffic');
		$exportTypeExpanded = ($this->SESS->getAdPremiumPurse() && $exportType == 'expanded');
		
		$recordTable = $isTraffic? ' ad_traffic_reports ' : ' ad_billings ';
	
		$isBanner = $isText = $isBoth = false;
		
		if(isset($_GET[$K="campaign"]))
			$campaign = $this->ENGINE->sanitize_user_input($_GET[$K]);
		
		switch(strtolower($campaign)){
			
			case $this->getBannerCampaignType(): $isBanner = true; break;
				
			case $this->getTextCampaignType(): $isText = true; break;	
							
			default: $isBoth = true;
			
		}

		list($owner, $ownerId) = $this->SITE->getBackDoorViewOwnersParams();
		
		$mediaRootCampCSVXCL =  $this->SITE->getMediaLinkRoot("campaign-csv", false);
		$valArr = array($ownerId);
		$valArr[] = $isBoth? $ownerId : $campaign;
		$adId? ($valArr[] = $adId) : '';
		$bannerCampaignTable = 'banner_campaigns';
		$textCampaignTable = 'text_campaigns';
		
		$xSubQry = ($isBoth?  "  LEFT JOIN ".$bannerCampaignTable." cmp1 ON r.AD_ID=cmp1.ID LEFT JOIN ".$textCampaignTable." cmp2 ON r.AD_ID=cmp2.ID WHERE (cmp1.USER_ID=? || cmp2.USER_ID=? ) "		
					: "  JOIN ".($isBanner? $bannerCampaignTable : $textCampaignTable)." cmp ON r.AD_ID=cmp.ID WHERE (cmp.USER_ID=? AND r.CAMPAIGN_TYPE=? ".($adId? "AND r.AD_ID=?" : "").") ".
					(($isTraffic && !$exportTypeExpanded)? 'GROUP BY r.AD_ID, SOURCE_SECTION_ID, r.TIME ' : '')
					)."ORDER BY ".($isTraffic? "" : "r.CAMPAIGN_TYPE, r.AD_ID, BILLING_SECTION_ID,")." r.TIME DESC";
		$folder = $mediaRootCampCSVXCL;

		$file = $owner.($isBoth? '' : ($isBanner? '_banner' : '_text')).'_campaign_'.($adIdEnc? $adIdEnc.'_' : '').$exportItem.($exportTypeExpanded? '_expanded_ver' : '').'.csv';

		$path = $folder.$file;

		$fopened = fopen($path, "w");

		$csvColTitleArray = $isTraffic? array("ad id", "campaign type", "traffic origin", (($isTraffic && $exportTypeExpanded)? "traffic sender" : "clicks"), (($isTraffic && $exportTypeExpanded)? "ip" : "hits"), "day", "date") :
							array("ad id", "campaign type", "amount", "ad rate at billing", "premium rate applied", "section", "duration billed(mins)", "date");

		fputcsv($fopened, $csvColTitleArray);
		
		$n = $this->DBM->getMaxRowPerSelect();
		
		///////COMPILE THE CAMPAIGN DATAS FROM DB///////
		
		for($i=0 ;; $i += $n){
			
			///////////PDO QUERY//////

			$sql = "SELECT AD_ID, CAMPAIGN_TYPE, ".($isTraffic? "SOURCE_SECTION_ID, ".(($isTraffic && $exportTypeExpanded)? "SOURCE_USER_ID, IP" : "COUNT(*) AS CLICKS, COUNT(DISTINCT SOURCE_USER_ID,IP) AS HITS").", DAYNAME(r.TIME) AS DAY"
			: "BILLING_AMOUNT, BILLING_AD_RATE, BILLING_PREMIUM_RATE, BILLING_SECTION_ID, MINUTES_BILLED").", ".(($isTraffic && !$exportTypeExpanded)? "DATE(r.TIME)" : "r.TIME")." AS DATE FROM ".$recordTable." r ".$xSubQry." LIMIT ".$i.",".$n;
			
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr, true);
			
			/////IMPORTANT INFINITE LOOP CONTROL ////
			if(!$this->DBM->getSelectCount())
				break;
								
			while($datasArr = $this->DBM->fetchRow($stmt)){
				
				if($isTraffic && $exportTypeExpanded){	
				
					$trafficSender = $this->ACCOUNT->memberIdToggle($datasArr[$K="SOURCE_USER_ID"]);
					if(!$trafficSender) $trafficSender = 'A Guest';
					$datasArr[$K] = $trafficSender;
				
				}
				
				$datasArr[($K=($isTraffic? "SOURCE_SECTION_ID" : "BILLING_SECTION_ID"))] = $this->SITE->sectionIdToggle($datasArr[$K]);
				$datasArr[$K="CAMPAIGN_TYPE"] = ucwords($datasArr[$K]);
				$datasArr[$K="AD_ID"] = $this->INT_HASHER->encode($datasArr[$K]);
				fputcsv($fopened, $datasArr);
						
			}
			
		}
		
		fclose($fopened);
				
		///////DOWNLOAD THE FILE///////

		$this->ENGINE->download_handler(array("file"=>$file, "dir"=>$folder, "ctype"=>"text/csv", "cleanUp"=>true));

		
	}
	
	
	
	
	
	
	
	
	
	
	/* Method for handling campaign delete request */
	public function processCampaignDelete(){
		
		global $GLOBAL_mediaRootBannerXCL;
		
		$adminReferred=$campaign="";

		$sessAll = SESS_ALL;
		
		/////ALLOW ADMIN (OR TRUSTED)? USERS ACCESS/////
		
		if(isset($_POST[$K="adm-ref"]))
			$adminReferred = $_POST[$K];

		if(isset($_GET[$K]))
			$adminReferred = $_GET[$K];	

		if($adminReferred && $this->SESS->isAdmin()){
			
			////////ASSIGN ADMIN REFERRED USERNAME AS THE TARGET///////
			$username  = $adminReferred;	
			$userId = $this->ACCOUNT->memberIdToggle($adminReferred, true);
			
		}else{
			
			$username  = $this->SESS->getUsername();	
			$userId = $this->SESS->getUserId();
			
		}

		if((isset($_POST[$K="ad"]) || isset($_GET[$K])) && $userId){	
			
			if(isset($_POST[$K]))
				$campaignId = $_POST[$K];
			
			if(isset($_GET[$K]))
				$campaignId = $_GET[$K];	
			
			if(isset($_POST[$K="campaign"]))
					$campaign = $_POST[$K];
			
			if(isset($_GET[$K]))
				$campaign = $_GET[$K];	

			$campaign = $this->ENGINE->sanitize_user_input($campaign, array('lowercase' => true));
			$bannerCampaign = $this->getBannerCampaignType();
			$textCampaign = $this->getTextCampaignType();
			
			if($campaign && $campaignId){
				
				if($this->validateCampaignType($campaign)){
							
					if($campaign == $bannerCampaign){
				
						$campaignTable = $this->getBannerCampaignTable();	
						$typeCol = ', AD_IMAGE, BANNER_TYPE ';
						$isBannerCampaign = true;
					}					
					else{
				
						$campaignTable = $this->getTextCampaignTable();
						$typeCol = '';
				
					}
					
					$isSessAll = ($campaignId == $sessAll);
					$isSessAll? '' : ($campaignId = $this->ENGINE->sanitize_number($this->INT_HASHER->decode($campaignId))); 
					
					$n = $this->DBM->getMaxRowPerSelect();
					
					for($i=0; ; $i += $n){
						
						try{
														
							/////PDO QUERY///							
							if($isSessAll){
								
								$sql = "SELECT ID ".$typeCol." FROM ".$campaignTable." WHERE USER_ID=? LIMIT ".$i.",".$n;
								$valArr = array($userId);
									
							}else{
								
								$sql = "SELECT ID ".$typeCol." FROM ".$campaignTable." WHERE ID=? AND USER_ID=? LIMIT 1";
								$valArr = array($campaignId, $userId);
											
							}
							
							$stmt = $this->DBM->doSecuredQuery($sql, $valArr, true);
							
							/////IMPORTANT INFINITE LOOP CONTROL ////
							if(!$this->DBM->getSelectCount())
								break;
							
							// Run campaign delete transaction
							$this->DBM->beginTransaction();

							while($row = $this->DBM->fetchRow($stmt)){
											
								$adId = $row["ID"];
								
								##JUST INCASE THE AD IS ACTIVE, FORCE BILL BEFORE DELETE
								$this->adsBilling($campaign, $adId, true);
								
								if(isset($isBannerCampaign)){
									///DELETE FILES RELATING TO THE CAMPAIGN BEING DELETED///
									
									$path2del = $GLOBAL_mediaRootBannerXCL.$row["AD_IMAGE"];
									
									if(realpath($path2del) && $row["AD_IMAGE"])
										unlink($path2del);
									
								}
								
								//CLEANUP RESIDUAL RECORDS
								$this->adDelCleanUp($adId);
								
							}
										
									
							if($isSessAll){
								
								///PDO QUERY///////
							
								$sql = "DELETE FROM  ".$campaignTable." WHERE USER_ID=?";
								$valArr = array($userId);
							
							}else{

								///PDO QUERY////
							
								$sql = "DELETE FROM ".$campaignTable." WHERE ID=? AND USER_ID=? LIMIT 1";
								$valArr = array($campaignId, $userId);
										
								
							}
							
							$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
							
							// If we arrived here then our campaign delete transaction was a success, we simply end the transaction
							$this->DBM->endTransaction();
							
							
						}catch(Throwable $e){
							
							// Rollback if active campaign removal transaction fails
							$this->DBM->cancelTransaction();
							
						}
						
					}	
				}			
			}	
		}
		
		if($rdrAlt = $this->getReturnUrl())
			header("Location:".$rdrAlt);
					
		elseif(!$this->ENGINE->is_ajax())
			header("Location:".$rdrAlt);
			
		exit();
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


	 




	 

	
	/* Method for billing active ads per minutes of impressions */
	public function adsBilling($fbCampType='', $fbAdId='', $forceBillCleanup=false, $getBillingComputationOnlyByDur=0){
		
		$fbCnd  = '';
		$siteName = $this->siteName;
		$siteDomain = $this->siteDomain;
		$valArrMain = $usersExhCrdArr = $usersSentNtfArr = array();
		$isForceBill = false;
		$maxPerDbRow = $this->DBM->getMaxRowPerSelect();				
		$campaignMetas = $this->getMeta("static");				
		
		// GRAB THE DEFAULT CAMPAIGN TYPE OF THE CALLING OBJECT SO AS TO RESTORE IT BACK AFTER THE BILLING 
		$oldCampaignType = $this->getCampaignType();
			
		//LOOP ALL SECTIONS WITH ADS FOR EACH CAMPAIGN TYPE///
		
		$campaignTypesArr = $this->getCampaignTypes();
		$totalCampaignTypes = count($campaignTypesArr);

		foreach($campaignTypesArr as $campaignType){
			
			###IF FORCE BILLING AN AD 
			if($fbCampType && $fbAdId){
				
				$campaignType = $fbCampType;
				$fbCnd = ' AND act.AD_ID = ? ';
				$valArrMain = array($fbAdId);
				$isForceBill = true;
				
			}
			
			// SET THE CAMPAIGN TYPE (VERY CRUCIAL AND CRITICAL)
			$this->setCampaignType($campaignType);
			
			if($campaignType == $this->getBannerCampaignType()){
				
				$campaignTable = $this->getBannerCampaignTable();
				$btypeCol = ', BANNER_TYPE ';
				$adTypesCommaList = $this->getBannerAdTypesCommaList();
				
			}else{
				
				$campaignTable = $this->getTextCampaignTable();
				$btypeCol = '';
				$adTypesCommaList = $this->getTextAdTypesCommaList();
				
			}
				
			
			$billingAcc = 0;
			
			/*******************
				
				IMPORTANT NOTE:
				
				The loop syntax "for($ii=0; ; ii += $maxPerDbRow)" could not be used because of the reasons explained below:
				
				Running the billing sql in a loop helps optimize memory consumption, however, it posses critical challenges explained below:
				
				CRITICAL CHALLENGE:
				
				While in the loop syntax described above, one or more ads may be removed from active section ad table,
				this will in turn short the loop index by that equivalent number of removal which of course will cause the next iteration of the loop 
				to skip some database record/row matching those index that was cut short.
				
				Example:
				
				During first iteration ii = 0 and maxPerDbRow = 100;
				while in this loop we remove 2 ads from the table 
				
				During the second iteration, ii = 100  and maxPerDbRow = 100;
				Remember that 2 rows were removed in first iteration, the database however cannot remember
				that during the second iteration since we are using the LIMIT clause to fetch 100 records at a time 
				starting at the specified index; in this case index 100. 
				The database runs the sql again but this time, 2 records have now occupied index 98 and 99 to get the set limit of 100,
				therefore when we get the records for the second iteration starting from index 100, we have automatically missed the record
				that filled index 98 and 99.
				
				ADOPTED SOLUTION:
				
				To fix this, we added a BILLED field in the database table which we update on the fly during billing to help keep track of the
				rows that has been billed for the current cycle. We also keep the record fetch index at constant zero (0) since each iteration
				will only fetch rows that has not been marked billed for the current cycle.
				At the end of the billing we prepare the table for the next billing cycle by simply setting the BILLED field to 
				its default zero (0) state (meaning not yet billed)
				
			*******************/
			
			$incrIndex = ($getBillingComputationOnlyByDur? $maxPerDbRow : 0);
			
			for($ii=0; ; $ii += $incrIndex){
				
				
				//PDO QUERY///////////
				
				$sql =  "SELECT act.ID AS ROW_ID, act.AD_ID, act.AD_TYPE, ACTIVE_TIME, COALESCE(TIMESTAMPDIFF(MINUTE, ACTIVE_TIME, NOW()), 0) AS ACTIVE_MINUTES, MINUTES_ACTIVE_BEFORE, 
				camp.ID".$btypeCol.", USER_ID, FIRST_NAME, USERNAME, EMAIL, CAMPAIGN_NTF, s.ID AS SECTION_ID
				FROM active_section_ads act JOIN sections s ON act.SECTION_ID=s.ID JOIN ".$campaignTable." camp ON camp.ID=act.AD_ID
				JOIN users u ON camp.USER_ID=u.ID WHERE (".($getBillingComputationOnlyByDur? "" : "act.BILLED !=1 AND ")."act.AD_TYPE IN(".$adTypesCommaList.")".$fbCnd.") ORDER BY s.ID ASC LIMIT ".$ii.",".$maxPerDbRow;
				
				$stmt = $this->DBM->doSecuredQuery($sql, $valArrMain, true);
				
				/////IMPORTANT INFINITE LOOP CONTROL ////
				if(!$this->DBM->getSelectCount())
					break;
						
				while($billRow = $this->DBM->fetchRow($stmt)){
					
					##IMPORTANT NOTE: CAST ALL RATE VALUES TO SAME AS DATABASE FIELD TYPE 
					$rowId = $billRow["ROW_ID"];
					$sectionId = $billRow["SECTION_ID"];
					$adType = $billRow["AD_TYPE"];
					$adIdUnderBill = $billRow["AD_ID"];
					$bannerType = isset($billRow[$K="BANNER_TYPE"])? $billRow[$K] : '';
					$stillActive = (int)$billRow["ACTIVE_TIME"];
					$activeMinutes = (int)$billRow["ACTIVE_MINUTES"];
					$activeMinutesBefore = (int)$billRow["MINUTES_ACTIVE_BEFORE"];
					$adOwnerId = $billRow["USER_ID"];
					$adOwner = $billRow["USERNAME"];
					$firstName = $billRow["FIRST_NAME"];
					$adOwnerCampNtf = $billRow["CAMPAIGN_NTF"];
					$adOwnerEmail = $billRow["EMAIL"];
					//TOTAL NUMBER OF MINUTES AN AD HAS BEEN ACTIVE
					$adActiveDur = ($getBillingComputationOnlyByDur? $getBillingComputationOnlyByDur : ($activeMinutes + $activeMinutesBefore));
					
					##GET THE COMPUTED BILLING PER AD AND SECTION
					$computedBillingArr = $this->getComputedAdBilling($adOwnerId, $sectionId, $campaignType, $bannerType, $adActiveDur);
					$amountBilled = $computedBillingArr["amountBilled"];
					$adOwnerPurse = $computedBillingArr["adOwnerPurse"];
					$adOwnerPremiumPurse = $computedBillingArr["adOwnerPremiumPurse"];
					$adRate = $computedBillingArr["adRate"];
					$totalAdRatePerCron = $computedBillingArr["totalAdRatePerCron"];
					$discountRate = $computedBillingArr["discountRate"];
					$totalDiscountPerCron = $computedBillingArr["totalDiscountPerCron"];
					$premiumRate = $computedBillingArr["premiumRate"];
					$onPremiumRate = $computedBillingArr["onPremiumRate"];
					$computedPremiumRate = $computedBillingArr["computedPremiumRate"];
					$discountIsPremium = $computedBillingArr["discountIsPremium"];
					
					
					/////IF EXCLUSIVELY REQUESTING FOR BILLING COMPUTATION PER AD_ID ONLY////
					if($getBillingComputationOnlyByDur){
			
						$billingAcc += $amountBilled;
						continue;
			
					}
					
					##UPON PURCHASE OF PREMIUM AMOUNT CREDITS, THE SYSTEM RECORDS IT AND USES IT TO TRACK IF A USER
					##IS STILL ELIGIBLE FOR PREMIUM OFFERS/DISCOUNTS AND THE AMOUNT DROPS AS THE USER IS BILLED
					$prmPurseBillingSubQry = ($discountIsPremium && $adOwnerPremiumPurse)? (', ADS_PREMIUM_PURSE = '.(($adOwnerPremiumPurse >= $totalDiscountPerCron)? ($adOwnerPremiumPurse - $totalDiscountPerCron) : 0)) : '';
					
					
					/////BILL THE AD OWNER IF HE HAS ENOUGH CREDIT////
					if($adOwnerPurse >= $amountBilled){					
						
						///PDO QUERY///

						$sql = "UPDATE users SET ADS_CREDITS_AVAIL = (ADS_CREDITS_AVAIL - ?), ADS_CREDITS_USED = (ADS_CREDITS_USED + ?) ".$prmPurseBillingSubQry." WHERE ID=? LIMIT 1";
						$valArr = array($amountBilled, $amountBilled, $adOwnerId);
						$this->DBM->doSecuredQuery($sql, $valArr);
						
						###AFTER BILLING, IF THE AD IS NO LONGER IN THE SECTION OR IS FORCE BILLING THEN DELETE IT FROM ACTIVE ADS 
						if(!$stillActive || $forceBillCleanup){
							
							$this->removeFromActiveAdSlots(array("adId"=>$adIdUnderBill, "sid"=>$sectionId, "del"=>true));
							
						}##OTHERWISE, UPDATE THE AD FOR NEXT BILLING
						else{
							
							$sql = "UPDATE active_section_ads SET ACTIVE_TIME = NOW(), MINUTES_ACTIVE_BEFORE=0 WHERE (SECTION_ID=? AND AD_ID=? AND AD_TYPE=?) LIMIT 1";
							$valArr = array($sectionId, $adIdUnderBill, $adType);
							$this->DBM->doSecuredQuery($sql, $valArr);
							
						}					
						
					}else{
						
						$userExhaustedCredit = true;
						
						////IF THE USER RUNS OUT OF CREDITS THEN REMOVE ALL HIS ADS FROM ALL SECTIONS /////									
														
						$this->removeFromActiveAdSlots(array("uid"=>$adOwnerId, "del"=>true, "ignoreCampaignAdType"=>true));
					
						//FINALLY EMPTY THE REMAINING CREDITS IN THE USER ACCOUNT////
						
						//PDO QUERY/////

						$sql = "UPDATE users SET ADS_CREDITS_AVAIL=0, ADS_CREDITS_USED = (ADS_CREDITS_USED + ?) ".$prmPurseBillingSubQry." WHERE ID=? LIMIT 1";
						$valArr = array($adOwnerPurse, $adOwnerId);
						$this->DBM->doSecuredQuery($sql, $valArr);								
													
						///SEND NOTIFICATION EMAIL IF ALLOWED AND IF NOT ALREADY SENT/////							
						
						if($adOwnerCampNtf && !in_array($adOwnerId, $usersSentNtfArr)){
							
							///TRACK USERS ALREADY SENT THIS NTF////
							$usersSentNtfArr[] = $adOwnerId;
												
							$to = $adOwnerEmail;

							$subject = 'Ad Credits Exhausted';
							 
							$message = 'Hello '.$this->ACCOUNT->sanitizeUserSlug($adOwner, array('anchor'=>true, 'youRef'=>false, 'preUrl'=>$siteDomain, 'isRel'=>false)).', \n You have exhausted your Advertising Campaign Credits and as a result your campaigns has now been <b '.EMS_PH_PRE.'RED>DEACTIVATED</b> from all sections.\n <div '.EMS_PH_PRE.'DANGER_BOX>TIME OF DEACTIVATION WAS ON: '.date(' l, dS M, Y, \a\t h:iA').'</div> \nPlease purchase more Ad credits to resume your campaign. \nThank you for Advertising with Us.\n\nBest regards,\n<a href="'.$siteDomain.'">'.$siteName.'</a> Ads Campaign Team\n\n\n';
										
							$footer = 'NOTE: This email was sent to you because you are running an Ad Campaign at  <a href="'.$siteDomain.'">'.$siteDomain.'</a>. Please kindly ignore this message if otherwise.\n\n\n Please do not reply to this email.';
							 
							$this->SITE->sendMail(array('to'=>$to.'::'.$firstName, 'subject'=>$subject, 'body'=>$message, 'footer'=>$footer));
							
						}
																						
					}
					
					
					//MARK THE ROW AS BILLED IN THE DATABASE TABLE TO EXCLUDE IT FROM NEXT LOOP ITERATION
					
					///PDO QUERY///

					$sql = "UPDATE active_section_ads SET BILLED = 1 WHERE ID=? LIMIT 1";
					$valArr = array($rowId);
					$this->DBM->doSecuredQuery($sql, $valArr);
					
					
					/******
					NOTE: FORCE BILLING IS MAINLY USED TO BILL THOSE AD THAT ARE ACTIVE IN A SECTION AND THE OWNER SUDDENLY 
					TRIGGER A DELETE ON IT. OBVIOUSLY WE NEED TO BILL THE AD FOR THE ACTIVE TIME ALREADY SPENT BEFORE
					DELETING IT. ALSO NO NEED TO KEEP THE BILLING RECORD SINCE IT'S BEING DELETED ANYWAY.
					
					ENSURE RECORDED BILLINGS DON'T EXCEED USER'S TOTAL CREDITS AVAILABLE
					AND DON'T RECORD FOR USERS THAT HAVE BEEN MARKED EXHAUSTED AND ALSO WHEN FORCE BILLING
					*****/
					if(in_array($adOwnerId, $usersExhCrdArr) || $adOwnerPurse <= 0 || $isForceBill)
						continue;		
											
					if(isset($userExhaustedCredit)){
			
						$usersExhCrdArr[] = $adOwnerId;
						$amountBilled = $adOwnerPurse;
			
					}
			
					##RECORD BILLINGS > 0 ONLY
					if($amountBilled){
			
						/////RECORD BILLING IN DB///////
						
						//PDO QUERY/////

						$sql =  "INSERT INTO ad_billings (AD_ID, BILLING_AMOUNT, BILLING_SECTION_ID, BILLING_AD_RATE, BILLING_PREMIUM_RATE, MINUTES_BILLED, CAMPAIGN_TYPE) VALUES(?,?,?,?,?,?,?)";
						$valArr = array($adIdUnderBill, $amountBilled, $sectionId, $adRate, $computedPremiumRate, $adActiveDur, $campaignType);
						$this->DBM->doSecuredQuery($sql, $valArr);
			
					}
			
					#UNCOMMENT FOR DEBUGGING
					/*echo '==>AD_ID: '.$adIdUnderBill.' ==>SID: '.$sectionId.'<br/><br/>';
						echo 'OWNER:'.$adOwner.'===>'.$amountBilled.'=>SECTION:'.$this->SITE->sectionIdToggle($sectionId).'=>AD_RATE:'.$adRate.'=>RATE_CAL:
						'.$totalAdRatePerCron.'=>DISC_RATE:'.$discountRate.'=>DISC_CAL:'.$totalDiscountPerCron.'
						=>PRM_RATE:'.$premiumRate.'=>BANNER_TYPE:'.$bannerType.'=>MIN:'.$adActiveDur.'
						==>PRM_PURSE_QRY'.$prmPurseBillingSubQry.'<br><br>';
					*/
			
				}
					
			
			}
				
			##SINCE FORCE BILLING IS SPECIFIC TO A CAMPAIGN TYPE ENSURE TO BREAK
			##ONCE DONE FOR THE CAMPAIGN TYPE
		
			if($isForceBill || $getBillingComputationOnlyByDur)
				break;
				
		}
		
		if(!$getBillingComputationOnlyByDur){
			
			//ENSURE TO UNMARK THE ROWS AS BILLED IN THE DATABASE TABLE TO PREPARE IT FOR NEXT BILLING CYCLE
			
			///PDO QUERY///

			$sql = "UPDATE active_section_ads SET BILLED = 0";
			$valArr = array();
			$this->DBM->doSecuredQuery($sql, $valArr);
			
			
		}

		// RESTORE THE DEFAULT CAMPAIGN TYPE OF THE CALLING OBJECT EARLIER GRABBED BEFORE THE BILLING 
		$this->setCampaignType($oldCampaignType);
			
		return ($getBillingComputationOnlyByDur? $billingAcc : true);
		
	}

	
	


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*** Cron job scripts ***/
	
	

	/* Method for deleting disapproved ads older than a specific time (cron job) */
	public function adTableCleanUp(){
		
		$cnd = " WHERE ((TIME + INTERVAL 2 WEEK) <= NOW() AND APPROVAL_STATUS=".$this->getDisapprovedAdState().") ";
		///////////PDO QUERY//////
		
		$maxPerDbRow = $this->DBM->getMaxRowPerSelect();
		
		try{			
		
			for($i=0; ; $i += $maxPerDbRow){
				
				$sql = "SELECT ID, AD_IMAGE FROM banner_campaigns ".$cnd." LIMIT ".$i.",".$maxPerDbRow;
				$valArr = array();
				$this->DBM->doSecuredQuery($sql, $valArr, true);
				
				/////IMPORTANT INFINITE LOOP CONTROL ////
				if(!$this->DBM->getSelectCount())
					break;
					
				// Run ad table cleanup transaction
				$this->DBM->beginTransaction();
							
				while($row = $this->DBM->fetchRow($stmt)){
								
					$adId = $row["ID"];
					
					///DELETE FILES RELATING TO THE CAMPAIGN BEING DELETED///
					
					$path2del = $this->mediaRootBannerXCL.$row["AD_IMAGE"];
					
					if(realpath($path2del) && $row["AD_IMAGE"])
						unlink($path2del);
					
					//CLEANUP RESIDUAL RECORDS
					$this->adDelCleanUp($adId);
					
				}
				
			}
				
			$sql =  "DELETE FROM banner_campaigns ".$cnd."; DELETE FROM text_campaigns ".$cnd;
			$valArr = array();
			$this->DBM->doSecuredQuery($sql, $valArr);
			
			// If we arrived here then our ad table cleanup transaction was a success, we simply end the transaction
			$this->DBM->endTransaction();
			
			return true;
			
		}catch(Throwable $e){
			
			// Rollback if ad table cleanup transaction fails
			$this->DBM->cancelTransaction();
			
			return false;
			
		}
		
	}











	/* Method for going premium with section ad a rates (cron job) */
	public function placeSectionsOnAdPremiumRate(){
		
		$maxPerDbRow = $this->DBM->getMaxRowPerSelect();
		
		for($ii=0; ; $ii += $maxPerDbRow){
			
			/////////PDO QUERY////////
			
			$sql =  "SELECT ID, SECTION_NAME FROM sections WHERE MIN_PREMIUM_RATE > 0 LIMIT ".$ii.",".$maxPerDbRow;

			$valArr = array();
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr, true);
			
			/////IMPORTANT INFINITE LOOP CONTROL ////
			if(!$this->DBM->getSelectCount())
				break;
						
			while($row = $this->DBM->fetchRow($stmt)){
				
				$sectionId = $row["ID"];
				
				$availableAdSlotsArr = $this->getAdSlots($sectionId, $head="", $countAll=false, $retType='available');
				$adTypeSlotsFilled = count(array_filter($availableAdSlotsArr, function($v){return ($v == 0);}));
				
				//echo$row["SECTION_NAME"].' ===>>> adTypeSlotsFilled: '.$adTypeSlotsFilled.' ===>>> '.var_export($availableAdSlotsArr,true).'<br/>';//FOR DEBUG
				
				/*****PLACE A SECTION ON PREMIUM RATE WHEN AT LEAST 2 OF ITS AD TYPES HAVE THEIR SLOTS FILLED*****/
				
				$sql = "UPDATE sections SET ON_PREMIUM_RATE=".(($adTypeSlotsFilled >= 2)? 1 : 0)." WHERE ID=? LIMIT 1";
				$valArr = array($sectionId);
				$this->DBM->doSecuredQuery($sql, $valArr);
				
			}			
			
		}
	}












	/* Method for do traffic to ad ad rates correlation (cron job) */
	public function correlateAdRates(){
		
		$maxPerDbRow = $this->DBM->getMaxRowPerSelect();
		
		for($ii=0; ; $ii += $maxPerDbRow){
			
			/////////PDO QUERY////////
			
			$sql =  "SELECT ID, SECTION_NAME, SECTION_SLUG, MIN_AD_RATE, MIN_PREMIUM_RATE, MIN_DISCOUNT_RATE, CORRELATED_AD_RATE, CORRELATED_OLD_AD_RATE FROM sections ORDER BY ID ASC LIMIT ".$ii.",".$maxPerDbRow;

			$valArr = array();
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr, true);
			
			/////IMPORTANT INFINITE LOOP CONTROL ////
			if(!$this->DBM->getSelectCount())
				break;
						
			while($row = $this->DBM->fetchRow($stmt)){
				
				$isHomepage = false;
				$sectionId = $row["ID"];
				$minAdRate = $row["MIN_AD_RATE"];
				$correlatedDbAdRate = $row["CORRELATED_AD_RATE"];
				$correlatedOldAdRate = $row["CORRELATED_OLD_AD_RATE"];
				$minPremiumRate = $row["MIN_PREMIUM_RATE"];
				$minDiscountRate = $row["MIN_DISCOUNT_RATE"];
				$sectionName = $row["SECTION_NAME"];
				$sectionNameSlug = $this->ENGINE->sanitize_slug($sectionName);
			
				if($sectionId == HOMEPAGE_SID){
			
					$sectionNameSlug = $this->siteDomain;
					$isHomepage = true;
			
				}
				
				$sql =  "SELECT count(*) FROM site_traffic WHERE (PAGE_ON_VIEW=? OR SECTION_ID=?)";
				$valArr = array($sectionNameSlug, $sectionId);
				$sectionTraffic = $this->DBM->doSecuredQuery($sql, $valArr)->fetchColumn();
				
				
				/********CORRELATE RATES*******/
				
				#RATIO x : y IMPLIES INCREASE RATE BY x FOR EVERY y RISE IN TRAFFIC MULTIPLIER
				
				$trafficRatio = 30;
				
				/**
					SET A TRAFFIC BENCHMARK SO THAT CORRELATED RATES ARE NOT OUTRAGEOUS WHEN TRAFFIC BECOMES REALLY HIGH 
					
					NOTE THE BENCHMARK RATIO MUST BE SUCH THAT CORRELATE THE RATES ONLY TOWARDS THE POSITIVE DIRECTION
					BUT AT A SLOWER PACE. IT IS NOT MEANT TO DECREASE THE RATE BUT RATHER READJUST THE TRAFFIC RATIO
					TO CORRELATE AT A SLOWER UNITS/PACE FOR TRAFFICS ABOVE THE STIPULATED BENCHMARK 
					
					
					###CHOOSING A BENCHMARK RATIO RELATIVE TO THE SET BENCHMARK
					E.G
					A TRAFFIC RATIO OF 30 WITH A TARFFIC BENCHMARK OF 5000 WILL YIELD MAXIMUM INCREMENT OF 5000/30 = 166.667
					
					NOW ALL TRAFFIC LEVELS ABOVE THIS BENCHMARK MUST YIELD A VALUE HIGHER THAN 166.667 FOR EVERY RISE
					IN TRAFFIC RATIO ABOVE 30. TO ACHIEVE THIS, WE SIMPLY USE RATIO RELATIONSHIP
					
					(166.667 + RISE_VALUE_PER_RATIO_RISE) = X / ($trafficRatio + RATIO_RISE)
					
					SAY WE CHOSE A RATIO_RISE OF 1 UNIT ABOVE 30 AND RISE_VALUE_PER_RATIO_RISE OF 0.6, WE GET  
					167.27 = X / 31 =>>> X = 5185.37 =>>>> BENCHMARK RATIO = 5185.75 - 5000 =>>>> BENCHMARK RATIO = 185.75
					BENCHMARK RATIO = 185.75 IMPLIES FOR EVERY 185.37 RISE ABOVE THE BENCHMARK, INCREASE TRAFFIC RATIO BY 1 UNIT
					 
					ADJUST RATIO_RISE AND RISE_VALUE_PER_RATIO_RISE ACCORDING TO WHAT YOU NEED
					DECREASING THE RATIO_RISE ALSO DECREASES THE GROWTH PACE OF CORRELATED RATES
					
					####TESTING YOUR CHOSEN BENCHMARK RATIO PACE
					
					WITHOUT THE BENCHMARK CONTROL, A TRAFFIC OF 10000 WITH A TRAFFIC RATIO OF 30 WILL GROW AT A PACE OF
					10000 / 30 = 333.333
					IF WE USE THE BENCHMARK CONTROL AND THE RATIO_RISE AND RISE_VALUE_PER_RATIO_RISE USED IN THE EXAMPLE 
					ABOVE, A TRAFFIC OF 10000 WILL HAVE A TRAFFIC RATIO OF ((10000 - 5000) / 185.75) + 30 = 56.92 
					AND WILL GROW AT A PACE OF
					10000 / 56.92 = 175.69
					
					AT BENCHMARK, WE HAVE TRIMMED DOWN THE GROWTH PACE BY (333.333 - 175.69) = 157.643 
					
					WE CAN TRIM IT DOWN THE MORE BY DECREASING THE RATIO_RISE VALUE
				**/
				
				##WE RE-ADJUST THE TRAFFIC RATIO WHEN TRAFFIC EXCEED THIS BENCHMARK 
				$trafficRatioBenchmark = 5000;
				$benchmarkRatio = 68.281;
			
				if($sectionTraffic > $trafficRatioBenchmark){
			
					##FOR EVERY $benchmarkRatio RISE ABOVE THE BENCHMARK, INCREASE TRAFFIC RATIO BY 1;
					$trafficRatio += (($sectionTraffic - $trafficRatioBenchmark) / $benchmarkRatio);
			
				}
				
				##AD RATE
				$trafficMultiplier = $sectionTraffic;
				$trafficToAdRateRatio = (1 / $trafficRatio); #ADJUST RATIO AS NEEDED
				$correlatedAdRate = (($trafficToAdRateRatio * $trafficMultiplier) + $minAdRate);
				
				##PREMIUM RATE
				$trafficMultiplier = abs($correlatedAdRate - $minAdRate);
				$trafficToPremiumRateRatio = (1 / 1.8); #ADJUST RATIO AS NEEDED 
				$correlatedPremiumRate = (($trafficToPremiumRateRatio * $trafficMultiplier) + $minPremiumRate);
				$correlatedPremiumRate = ($minPremiumRate > 0)? $correlatedPremiumRate : $minPremiumRate;#APPLY CORRELATION ONLY IF MIN_VALUE > 0
				
				##DISCOUNT RATE
				$trafficToDiscountRateRatio = (1 / 2.3); #ADJUST RATIO AS NEEDED
				$correlatedDiscountRate = (($trafficToDiscountRateRatio * $trafficMultiplier) + $minDiscountRate);
				$correlatedDiscountRate = ($minDiscountRate > 0)? $correlatedDiscountRate : $minDiscountRate;#APPLY CORRELATION ONLY IF MIN_VALUE > 0
				
				//echo$sectionNameSlug.'=>>'.$correlatedDbAdRate.'=>>'.$correlatedAdRate.'<br>';//FOR DEBUG
				
				/********************UPDATE DB WITH THE NEW CORRELATED RATES*********************/
				$sql = "UPDATE sections SET ".(($correlatedOldAdRate != $correlatedAdRate && $correlatedAdRate != $correlatedAdRate)? 'CORRELATED_OLD_AD_RATE=CORRELATED_AD_RATE,' : '')." CORRELATED_AD_RATE=?, CORRELATED_PREMIUM_RATE=?, CORRELATED_DISCOUNT_RATE=? WHERE ID=? LIMIT 1";
				$valArr = array($correlatedAdRate, $correlatedPremiumRate, $correlatedDiscountRate, $sectionId);
				$this->DBM->doSecuredQuery($sql, $valArr);
				
			}			
			
		}
	}





	 


	 


	 
	
	/* Method for placing approved and eligible ads into available section slots (cron job) */
	public function adsPlacementCron(){
				
		$siteDomain = $this->siteDomain;
		$siteName = $this->siteName;	
		
		
		$maxPerDbRow = $this->DBM->getMaxRowPerSelect();
		$campaignMetas = $this->getMeta("static");
		
		for($ii=0; ; $ii += $maxPerDbRow){
				
			try{					
				
				/////////PDO QUERY////////
				
				$sql =  "SELECT ID, SECTION_NAME FROM sections ORDER BY ID ASC LIMIT ".$ii.",".$maxPerDbRow;

				$valArr = array();
				$stmtx = $this->DBM->doSecuredQuery($sql, $valArr, true);
				
				/////IMPORTANT INFINITE LOOP CONTROL ////
				if(!$this->DBM->getSelectCount())
					break;
				
				// Run ad placement transaction
				$this->DBM->beginTransaction();
							
				$adTypesArr = $this->getCampaignAdTypesDetails();
				
				while($sectionRow = $this->DBM->fetchRow($stmtx)){
					
					$sectionId = $sectionRow["ID"];
					$sectionName = $sectionRow["SECTION_NAME"];
					$sectionNameSlug = $this->ENGINE->sanitize_slug($sectionName);
					
					if($sectionId == HOMEPAGE_SID) 
						$sectionNameSlug = "";
					
					foreach($adTypesArr as $adTypeArr){		
						
						$campaignType = $adTypeArr["campaignType"];
						$campaignTable = $adTypeArr["campaignTable"];		
						$adType = $adTypeArr["adType"];		
						$slotLimit = $adTypeArr["slots"];
						$bannerTypeQry = ($campaignType == $this->getBannerCampaignType())? ' AND BANNER_TYPE = ? ' : '';
						$campaignStatusActive = ' AND '.strtoupper($campaignType).'_CAMPAIGN_STATUS = 1 ';
						$enoughCredits = ' AND (ADS_CREDITS_AVAIL > '.$campaignMetas["minAdPlaceCredit"].')';
						$mainValArr = array($sectionId, $campaignType);
						$bannerTypeQry? ($mainValArr[] = $adType) : '';
						
						////GET ALL SECTIONS AND CHECK FOR EMPTY SLOTS//////
						
						//FOR EACH AD TYPES COLS, FETCH REMAINING SLOTS AND AVOID DUPS PLACEMENT//////
						$subQry = ",(SELECT GROUP_CONCAT(AD_ID) FROM active_section_ads WHERE (SECTION_ID = ? AND AD_TYPE = ?)) AS OLD_ADS ";
						$sql = "SELECT GROUP_CONCAT(AD_ID) AS OLD_ACTIVE_ADS, COUNT(*) AS SLOTS_FILLED ".$subQry." FROM active_section_ads WHERE (SECTION_ID = ? AND AD_TYPE = ? AND ACTIVE_TIME !=0)";
						$valArr = array($sectionId, $adType, $sectionId, $adType);
						$stmt = $this->DBM->doSecuredQuery($sql, $valArr);
						$oldAdsRow = $this->DBM->fetchRow($stmt);
						$slotsFilled = (int)$oldAdsRow["SLOTS_FILLED"];
						$oldActiveAdsInSection = $oldAdsRow["OLD_ACTIVE_ADS"];
						$oldActiveAdsInSectionArr = explode(',', $oldActiveAdsInSection);
						$oldAdsInSection = $oldAdsRow["OLD_ADS"];
						$oldAdsInSectionArr = explode(',', $oldAdsInSection);
						///MAKES SURE YOU DON'T PLACE AN AD MORE THAN ONCE
						$noDupsSubQry = $oldActiveAdsInSection? " AND cmp.ID NOT IN(".$oldActiveAdsInSection.") " : "";
						
						//////IF THERE IS A VACCANT SLOT THEN FILL//////
						if($slotsFilled < $slotLimit){																	
													
							#####DO PLACING OF ADS THAT MEETS ALL CRITERION OF ADS PLACEMENT INTO SECTION#######
							/***FETCH  THE ADS AND SORT THEM BY THE PLACEMENT TIME 
								LIMIT TO ONLY AVAILABLE SLOTS
							***/
			
							$limit = ($slotLimit - $slotsFilled);
								
							/////////PDO QUERY////////															
							$sql =  "SELECT cmp.ID, cmp.USER_ID, u.FIRST_NAME, u.USERNAME, u.CAMPAIGN_NTF, u.EMAIL  FROM ".$campaignTable." cmp JOIN ad_pending_placements plcm ON cmp.ID=plcm.AD_ID 
							JOIN users u ON cmp.USER_ID=u.ID WHERE (plcm.SECTION_ID = ?  AND plcm.CAMPAIGN_TYPE = ? AND cmp.APPROVAL_STATUS = ".$this->getApprovedAdState()." ".$bannerTypeQry.
							$campaignStatusActive.$enoughCredits.$noDupsSubQry.") ORDER BY plcm.TIME ASC, plcm.AD_ID ASC LIMIT ".$limit;

							$stmt = $this->DBM->doSecuredQuery($sql, $mainValArr);
							
							while($campRow = $this->DBM->fetchRow($stmt)){
								
								$adOwnerId = $campRow["USER_ID"];
								$adOwner = $campRow["USERNAME"];
								
								if($adOwnerId){
									
									$activateAdId = $campRow["ID"];	
									$activateAdIdEnc = $this->INT_HASHER->encode($activateAdId);	
									$adOwnerCampNtf = $campRow["CAMPAIGN_NTF"];
									$adOwnerEmail = $campRow["EMAIL"];
									$firstName = $campRow["FIRST_NAME"];
									
									//PLACE THE ADS THAT MEETS ALL REQUIREMENTS
									if(in_array($activateAdId, $oldAdsInSectionArr)){
			
										$sql = "UPDATE active_section_ads SET ACTIVE_TIME = NOW() WHERE (SECTION_ID = ? AND AD_ID = ? AND AD_TYPE = ?) LIMIT 1";
										

									}else{
			
										$sql = "INSERT INTO active_section_ads (SECTION_ID, AD_ID, AD_TYPE, ACTIVE_TIME) VALUES(?,?,?,NOW())";
			
									}
									
									$valArr = array($sectionId, $activateAdId, $adType);
									
									///SEND NOTIFICATION EMAIL IF ALLOWED/////
									if($this->DBM->doSecuredQuery($sql, $valArr) && $adOwnerCampNtf){
										
										$to = $adOwnerEmail;

										$subject = 'Ad Activated';
										 
										$message = 'Hello '.$this->ACCOUNT->sanitizeUserSlug($adOwner, array('anchor'=>true, 'youRef'=>false, 'preUrl'=>$siteDomain, 'isRel'=>false)).', \n Your '.$campaignType.' Ad with ID: <a href="'.$siteDomain.'/ads-campaign/'.$campaignType.'-campaign#'.$activateAdIdEnc.'"><b>'.$activateAdIdEnc.'</b></a> is now <span '.EMS_PH_PRE.'GREEN>ACTIVE</span> in the <a href="'.$siteDomain.'/'.$sectionNameSlug.'">'.$sectionName.'</a> '.((in_array($sectionId, VIRTUAL_CSID_ARR))? 'category' : ((in_array($sectionId, array(HOMEPAGE_SID)))? '' : 'section')).'\n <div '.EMS_PH_PRE.'SUCCESS_BOX>TIME OF ACTIVATION WAS ON: '.date(' l, dS M, Y, \a\t h:iA').'</div> \nThank you for Advertising with Us.\n\nBest regards,\n<a href="'.$siteDomain.'">'.$siteName.'</a> Ads Campaign Team\n\n\n';
													
										$footer = 'NOTE: This email was sent to you because you are running an Ad Campaign at  <a href="'.$siteDomain.'">'.$siteDomain.'</a>. Please kindly ignore this message if otherwise.\n\n\n Please do not reply to this email.';
										 
										$this->SITE->sendMail(array('to'=>$to.'::'.$firstName, 'subject'=>$subject, 'body'=>$message, 'footer'=>$footer));
										
									}
					
								}
					
							}																							
						
						}else
							continue;
					}
				}
				
				// If we arrived here then our ad placement transaction was a success, we simply end the transaction
				$this->DBM->endTransaction();
				

			}catch(Throwable $e){
				
				// Rollback if ad placement transaction fails
				$this->DBM->cancelTransaction();
				return false;
				
			}
			
		}

		
		return true;

	}







	 

	
	/* Method for dispatching low campaign credit notification emails (cron job) */
	public function lowCreditNotificationDispatchCron(){
		
		$siteName = $this->siteName;
		$siteDomain = $this->siteDomain;
		$maxPerDbRow = $this->DBM->getMaxRowPerSelect();
		$campaignMetas = $this->getMeta("static");
		
		for($i=0; ; $i += $maxPerDbRow){
			
			// SEND NOTICE ONLY TO USERS WITH ACTIVATED CAMPAIGN NOTIFICATION STATUS
			/////////PDO QUERY////////
			$sql =  "SELECT USERNAME, FIRST_NAME, EMAIL, CAMPAIGN_NTF, ADS_CREDITS_AVAIL FROM users u 
					RIGHT JOIN banner_campaigns bc ON u.ID = bc.USER_ID  
					LEFT JOIN text_campaigns tc ON u.ID = tc.USER_ID  
					JOIN active_section_ads ac ON bc.ID = ac.AD_ID OR tc.ID = ac.AD_ID 
					WHERE CAMPAIGN_NTF = 1 GROUP BY u.ID LIMIT ".$i.",".$maxPerDbRow;

			$valArr = array();
			$stmt = $this->DBM->doSecuredQuery($sql, $valArr, true);
			
			/////IMPORTANT INFINITE LOOP CONTROL ////
			if(!$this->DBM->getSelectCount())
				break;
			
			while($row = $this->DBM->fetchRow($stmt)){
				
				$adOwner = $row["USERNAME"];
				$firstName = $row["FIRST_NAME"];
				$adOwnerPurse = $row["ADS_CREDITS_AVAIL"];
				$adOwnerEmail = $row["EMAIL"];
				
				if($adOwnerPurse < ($minAdPlaceCredit = $campaignMetas["minAdPlaceCredit"]) && $adOwnerPurse > ($minAdPlaceCredit - 50)){
						
					$to = $adOwnerEmail;

					$subject = 'Low Ads Credit Notification';
					 
					$message = 'Hello '.$this->ACCOUNT->sanitizeUserSlug($adOwner, array('anchor'=>true, 'youRef'=>false, 'preUrl'=>$siteDomain, 'isRel'=>false)).', \n You are running low on your Advertising Campaign Credits.\n <div '.EMS_PH_PRE.'DANGER_BOX>YOUR REMAINING CREDIT IS: '.$this->ENGINE->format_number($adOwnerPurse, 2, false).'</div> \nWe advice you purchase more Ad credits to avoid your campaign from being deactivated from active sections once your credit runs out. \nThank you for Advertising with Us.\n\nBest regards,\n<a href="'.$siteDomain.'">'.$siteName.'</a> Ad Campaign Teams\n\n\n';
								
					$footer = 'NOTE: This email was sent to you because you are running an Ad Campaign at  <a href="'.$siteDomain.'">'.$siteDomain.'</a>. Please kindly ignore this message if otherwise.\n\n\n Please do not reply to this email.';
					 
					$this->SITE->sendMail(array('to'=>$to.'::'.$firstName, 'subject'=>$subject, 'body'=>$message, 'footer'=>$footer));
				
					
				}
				
			}
				
		}
		
	}





	 

	
	/* Method for running ads billing cron using transaction (cron job) */
	public function adsBillingCron(){
		
		
		try{
			
			// Run ads billing transaction
			$this->DBM->beginTransaction();
		
			$this->adsBilling();
		
			// If we arrived here then our ads billing transaction was a success, we simply end the transaction
			$this->DBM->endTransaction();
			
		}catch(Throwable $e){
			
			// Rollback if ads billing transaction fails
			$this->DBM->cancelTransaction();
			
			return false;
			
		}
		
		return true;
		
	}
	
	
}




			
?>