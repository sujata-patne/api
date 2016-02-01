<!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content=" initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,width=device-width" /> 
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Welcome to Daily Magic</title>
 </head>
 <body style="margin:0"> 
<div style="text-align:center">
				<img src="../assets/img/d2clogo_320x45.png" />
</div>
<?php
include_once '../config.php';
// include_once "../../../site/lib/functions.php";
include_once "../controller/download.history.controller.php";
$historyObj = new History(); 
$USERSTATUS = $userStatus;
include "portlets/header.php";

$THUMBNAIL_LIMIT = 2;
$STOREID = $storeID;
$historyObj->setStoreConfigs($STOREID);
$USERSTATUS = $userStatus;
$PROMOID = $promo;
$LINKURL =$linkUrl;
$SUBPARAM= $subParam;
$MSISDN = $msisdn;
$USERID = $userId;
//print_r($USERSTATUS);
$historyObj->setStoreConfigs($STOREID);
$historyObj->setUserStatus($USERSTATUS);
$historyObj->setMsisdn($MSISDN);
$historyObj->setUserid($USERID);

$USERINFO = $historyObj->getUserSubscribeInfo();
$FINALRESULT = $historyObj->getDownloadHistoryData();
//print_r($USERINFO);
$historyVideo = $FINALRESULT['Video'];

//$historyPhoto = $FINALRESULT['Wallpaper'];
 /*$historyPhoto = $historyVideo;*/
$THUMBURL = "http://d85mhbly9q6nd.cloudfront.net/";

// $USERSTATUS = "SUBSCRIBED";
//isSubscribed= true;
if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){ ?>
	<tr>
		<td height="40" align="center">		

		<center>
			<a href="direct2CG.php?c=1&<?=$PROMOID?>&f=account">Click Here to Subscribe</a> 
			<!-- <a href="moc_sub.php">Click Here to Subscribe</a> -->

		</center>			
			
		</td>
	</tr>
	<?php } ?>			
    <?php if( $USERINFO['isSubscribed'] == true){?>
	<tr>
		<td>
			<br>
			<strong>My Subscriptions</strong>
			<p>Your subscription to Daily Magic is valid upto <?=$USERINFO['UserSubscribeInfo'][0]['sub_end_date']?></p>
			<p>User Status: <?=$USERINFO['UserSubscribeInfo'][0]['sub_status']?></p>
		</td>
	</tr>
	<?php
	if(!empty($historyVideo)){

	?>
	<tr>
		<td><strong>Videos</strong></td>
	</tr>
	<tr>
		<td align="center">
			<table width="100%">
				<tr>
					<?php
					    $i = 0;
						foreach ( $historyVideo as $key => $value ) {
                      	 	 if(++$i > $THUMBNAIL_LIMIT) break; //For restricting thumbnails.
						?>
						<td align="center">
							<!--<img src="<?=$historyVideo[$i]['cm_thumb_url']?>?<?=$timestamp?>"  width="125" height="125" alt="" />-->
							<img src="<?=$THUMBURL?><?=$value['cm_id']?>_thumb_125_125.jpg" width="125" height="125" alt="" />
							<?php
							if(!empty($value['cm_genre'])){
								echo "<br />".$value['cm_genre']."<br />";
							} 
							?>
			
						</td>
						<?php
						
				       }
					?>	
      			</tr>
				<?php
				if(count($historyVideo) > 2){
				?>
	      			<tr>                
						<td height="30" colspan="3" align="right">
							<?  //echo $linkUrl.'history_list.php?page='.$next_page = $page+1 .'&type=Video' ?>
							<a  href="history.php" style="text-decoration:none;">More >></a>
						</td>
					</tr>
				<?php
				 }
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td height="10" align="center">&nbsp;</td>
	</tr>
	<?php
	}
	if(!empty($historyPhoto)){
	?>
	<tr>
		<td><strong>Photos</strong></td>
	</tr>
	<tr>
		<td align="center">
			<table width="100%">
				<tr>
						<?php
						 $i = 0;
					    
						foreach ( $historyPhoto as $key => $value ) {
							
                        if(++$i > $THUMBNAIL_LIMIT) break; //For restricting thumbnails.
						?>
						<td align="center">
											
							<!--<img src="<?=$historyPhoto[$i]['cm_thumb_url']?>?<?=$timestamp?>"  width="125" height="125" alt="" />-->
							<img src="<?=$THUMBURL?><?=$value['cm_id']?>_thumb_125_125.jpg" width="125" height="125" alt="" />
						</td>
						
					
					<?php
					}
					?>	
        			</tr>
        			<?php
					if(count($historyPhoto) > 2){
					?>

					<tr>                
						<td height="30" colspan="3" align="right">
							<?  //echo $linkUrl.'history_list.php?page='.$next_page = $page+1 .'&type=Photos' ?>
							<a href="history.php" style="text-decoration:none;">More >></a>
						</td>
					</tr>
					<?php
					}
					?>
			</table>
		</td>
	</tr>
	<tr>
		<td height="10" align="center">&nbsp;</td>
	</tr>
	<?php }
	}
	?>
	
	<tr>
		<td>
			<div>
      <ul style="margin: 0px; padding: 5px 10px">

  <p><strong>PRIVACY POLICY</strong></p>
  
  <p>We at Daily Magic are engaged in offering video blogging services (Services) on Daily Magic website and mobile platforms (including APP &amp; WAP) ("Daily Magic"). We respects the privacy of everyone who visits Daily Magic and are committed to maintaining the privacy and security of the personal information of all visitors/users of Daily Magic, in order to ensure that the objectives of Daily Magic can be fulfilled to the satisfaction of all users. The privacy policies (the "Privacy Policy") governs for you, as a user/visitor of a video blogging application "Daily Magic". By using/visiting Daily Magic Platform, you expressly consent to the information handling practices described in this document.</p>

  <p><strong>A.The Information Daily Magic collects:</strong></p>

    <li>User-provided information: When you access Daily Magic, you must provide access credentials in the form of your mobile number or such other details as may be requested as authentication. You may provide to us what is generally called "personally identifiable" information (such as your name, age, email address, mailing address, mobile number) in case you access/login, Daily Magic or otherwise use the features and functionality of the Daily Magic Platform such as by connecting your account on Daily Magic to your account on another service. You hereby agree that all information you provide to us as your personally identifiable information shall be truthful, accurate and complete. </li>
    
    <li>Information we get from your use of Services: We collect information about how you use the Service, like when you watch a video on Daily Magic it may collect following information:<br>
      1. Device Information: We may collect device-specific information such as operating system version, unique device identifiers, and mobile network information including the mobile number.<br>
      2. Log information: When you use Daily Magic Service it automatically collects and stores certain information in server logs. It includes – how you used the Service, your search queries, internet protocol address, device event information such as crashes, browser type, date and time of your request and referral URL.<br>
      3. Location Information: When you use Daily Magic Service we may collect and process information about your location, IP address, GPS and other sensors, Wi-Fi access points and cell towers.<br>
      4. Unique Application Number: The number and information about your installation may be sent to Daily Magicu when you install or uninstall the service.<br>

    </li>

    <li>Cookies Information: When you access Daily Magic Platform it may send one or more cookies to your device. A cookie is a small data file that is transferred to your device. Daily Magic may use both session cookies and persistent cookies to better understand how you interact with Services, to monitor aggregate usage by users and traffic routing on Services, and to customize and improve Services. If you do not want cookies from Daily Magic, you can instruct your browser, by changing its settings. However, some Services may not function properly if you disable cookies.</li>

    <li>If you are a registered user of our Services, Daily Magic provides you with tools and account settings to access or modify the profile information you provided to us and associated with your account. You can also permanently delete your Daily Magic account by contacting us.</li>

  <p><strong>B.How Daily Magic use information it collects:</strong></p>
    
    <li>We may use your contact data to send you information about its Services, respond to your requests and facilitate your use of the Services, solve any issues you might be facing, to let you know about upcoming changes and improvements. </li>
    <li>Daily Magic is Video Blogging platform, so information such as the video blog you follow, the content you like, comments you post, your profile photo etc. is information that you choose to be made public. Your public information is broadly and instantly disseminated. When you share information via the Services, you should think carefully about what you are making public.</li>
    <li>We may keep track of how you interact with links of Services, including our email notifications, SMS, by redirecting clicks or through other means. We do this to help improve our Services, for example to provide relevant category of content, and to be able to share aggregate click statistics such as how many times a particular link was clicked on.</li>
    <li>If you have synced or connected your Daily Magic account with your accounts on other services then we may display your profile name, profile photo on Daily Magic such as comments you may write will appear with your profile photo linked from your relevant social media account. </li>
    <li>We use Log Data to provide our Services and to measure, customize, and improve them. We use information collected from cookies and other technologies, like pixel tags, to improve user experience and overall quality of Daily Magic's Services. </li>
    <li>We use a variety of third-party services to help provide our Services, to help it understand the use/usage of its Services. These third-party service providers may use cookies and other technologies to collect information about your use of our Services and other websites and services, including your IP address, device ID, pages viewed, and links clicked.</li>

  <p><strong>C.Information Sharing and Disclosure</strong></p>

    <li>We will not share your personal information with companies, organizations or individuals outside of Daily Magic unless one of the following circumstances applies:<br>
    1. We will share your personal information with companies, organizations or individuals outside of Daily Magic when it has your consent to do so.<br>
    2. We may share personal information with our authorized service providers and affiliates that perform certain Services on our behalf. These Services may include fulfilling requests, processing payments, providing customer service and marketing assistance, performing business and sales analysis, supporting our website/APP/WAP functionality, and supporting contests, surveys and other features offered through our website and our mobile app. These service providers may have access to personal information needed to perform their functions but are not permitted to share or use such information for any other purposes.<br>
    3. For legal reasons - We will share personal information with companies, organization or individuals outside of Daily Magic if we have a good-faith belief that access, use, preservation or disclosure of the information is reasonably necessary to:<br>
      <ul>
        a. Meet any applicable law, regulation, legal process or enforceable governmental request<br>
        b. Enforce applicable Terms of Services, including investigation of potential violations<br>
        c. Detect, prevent or otherwise address, fraud, security or technical issues<br>
        d. Protect against harm to the rights, property or safety of google our users or the public as required or permitted by law.<br>
      </ul>
        
    </li>

    <li>However, nothing in this Privacy Policy is intended to limit any legal defenses or objections that you may have to a third party's, including a government's, request to disclose your information.</li>
    <li>Please also note that as our business grows, we may buy or sell various assets. In the unlikely event that we sell some or all of our assets, or Daily Magic is acquired by another company, information about our visitors may be among the transferred assets. The promises in this Privacy Policy will apply to your information as transferred to the new entity.</li>
    <li>We may share or disclose your non-private, aggregated or otherwise non-personal information, such as your public user profile information, public posts, the people you follow or that follow you, or the number of users who clicked on a particular link (even if only one did).</li>

  <p><strong>D.Information Security</strong></p>
    <li>We work hard to protect Daily Magic and our users from unauthorized access to or unauthorized alteration, disclosure or destruction of information we hold, in particular:</li>
    <li>We review our information collection, storage and processing practices, including physical security measures, to guard against unauthorized access to systems.</li>
    <li>We restrict access to personal information to Daily Magic employees, contractors, and agents who need to know that information in order to process it for us, and who are subject to strict contractual confidentiality obligations and may be disciplined or terminated if they fail to meet these obligations.</li>

  <p><strong>E.Changes </strong></p>

    <li>We reserve the right at any time to: change the terms of this Agreement, Policy; change the services, including eliminating or modifying any Content on or feature of the website and/or the mobile app; or change/charge any fees or charges for use of the services. Any changes we make will be effective immediately on notice, which we may give either by posting the new Agreement on Daily Magic or via electronic mail. Your use of the services after such notice will be deemed acceptance of such changes. Be sure to review this Agreement periodically to ensure your familiarity with the most current version. You will always be able to tell when the version was last updated by checking the "Last Revised" date in the footer of this Agreement/ Policy.</li>

  

  <p><strong>Terms of Service</strong></p>

  <p>These Terms of Service ("Terms") govern your access to and use of Daily Magic, including any Daily Magic mobile applications and websites (the "Services"), and any videos, information, text, graphics, photos or other materials uploaded, downloaded or appearing on the Services (collectively referred to as "Content"). Your access to and use of the Services is conditioned on your acceptance of and compliance with these Terms. By accessing or using the Services you agree to be bound by these 1) Terms of Services and 2) Privacy Policy. If you do not agree to any of these terms, or Privacy Policy, please do not use the Service.</p>

  <p>Although we may attempt to notify you when major changes are made to these Terms of Service, you should periodically review the most up-to-date version on the website of Daily Magic. Daily Magic, in its sole discretion, modify or revise these Terms of Service and policies at any time, and you agree to be bound by such modifications or revisions. Nothing in these Terms of Service shall be deemed to confer any third-party rights or benefits.</p>

  <p>A.These Terms of Service apply to all users of the Service, including users who are also contributors of Content on the Service. "Content" includes the text, comments, posts, software, scripts, graphics, photos, sounds, music, videos, audiovisual combinations, interactive features and other materials you may view on, access through, or contribute to the Service. The Service includes all aspects of including but not limited to all products, software and services offered via the Daily Magic website or mobile application.</p>
  <p>B.The Service may contain links to third party websites that are not owned or controlled by Daily Magic. Daily Magic has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party websites. By using the Service, you expressly relieve Daily Magic from any and all liability arising from your use of any third-party website. Accordingly, we encourage you to be aware when you leave the Service and to read the terms and conditions and privacy policy of each other website that you visit.</p>
  <p>C.In order to access some features of the Service, you will have to create a Daily Magic Account. You may never use another's account without permission. When creating your account, you must provide accurate and complete information. You must notify Daily Magic immediately of any breach of security or unauthorized use of your account.</p>
  <p>D.Although Daily Magic will not be liable for your losses caused by any unauthorized use of your account, you may be liable for the losses of Daily Magic or others due to such unauthorized use.</p>
  <p>E.General Use of the Service—Permissions and Restrictions - Daily Magic hereby grants you permission to access and use the Service as set forth in these Terms of Service, provided that:</p>
    <ul>
      <p>a.You agree not to distribute in any medium any part of the Service or the Content without Daily Magic's prior written authorization, unless Daily Magic makes available the means for such distribution through functionality offered by the Service (such as the Embeddable Player).</p>
      <p>b.You agree not to alter or modify any part of the Service.</p>
      <p>c.You agree not to access Content through any technology or means other than the video playback pages of the Service itself, the Embeddable Player, or other explicitly authorized means Daily Magic may designate.</p>
      <p>d.You agree not to use the Service for any of the following commercial uses unless you obtain Daily Magic's prior written approval: </p>
        the sale of access to the Service;<br>
        the sale of advertising, sponsorships, or promotions placed on or within the Service or Content; or<br>
        the sale of advertising, sponsorships, or promotions on any page of an ad-enabled blog or website containing Content delivered via the Service, <br>unless other material not obtained from Daily Magic appears on the same page and is of sufficient value to be the basis for such sales.
      <p>e.You agree not to use or launch any automated system, including without limitation, "robots," "spiders," or "offline readers," that accesses the Service in a manner that sends more request messages to the Daily Magic servers in a given period of time than a human can reasonably produce in the same period by using a conventional on-line web browser. Daily Magic reserves the right to revoke these exceptions either generally or in specific cases. You agree not to collect or harvest any personally identifiable information, including account names, from the Service, nor to use the communication systems provided by the Service (e.g., comments, email) for any commercial solicitation purposes. You agree not to solicit, for commercial purposes, any users of the Service with respect to their Content.</p>
      <p>f.In your use of the Service, you will comply with all applicable laws.</p>
      <p>g.Daily Magic reserves the right to discontinue any aspect of the Service at any time.</p>
    </ul>


  <p>F.<strong>Your Use of Content</strong> - In addition to the general restrictions herein, the following restrictions and conditions apply specifically to your use of Content.</p>
    <ul>
      <p>a.The Content on the Service, and the trademarks, service marks and logos ("Marks") on the Service, are owned by or licensed to Daily Magic, subject to copyright and other intellectual property rights under the law.</p>
      <p>b.Content is provided to you AS IS. You may access Content for your information and personal use solely as intended through the provided functionality of the Service and as permitted under these Terms of Service. You shall not download any Content unless you see a "download" or similar link displayed by Daily Magic on the Service for that Content. You shall not copy, reproduce, make available online or electronically transmit, publish, adapt, distribute, transmit, broadcast, display, sell, license, or otherwise exploit any Content for any other purposes without the prior written consent of Daily Magic or the respective licensors of the Content. Daily Magic and its licensors reserve all rights not expressly granted in and to the Service and the Content.</p>
      <p>c.You agree not to circumvent, disable or otherwise interfere with security-related features of the Service or features that prevent or restrict use or copying of any Content or enforce limitations on use of the Service or the Content therein.</p>
      <p>d.You understand that when using the Service, you will be exposed to Content from a variety of sources, and that Daily Magic is not responsible for the accuracy, usefulness, safety, or intellectual property rights of or relating to such Content. You further understand and acknowledge that you may be exposed to Content that is inaccurate, offensive, indecent, or objectionable, and you agree to waive, and hereby do waive, any legal or equitable rights or remedies you have or may have against Daily Magic with respect thereto, and, to the extent permitted by applicable law, agree to indemnify and hold harmless Daily Magic, its owners, operators, affiliates, licensors, and licensees to the fullest extent allowed by law regarding all matters related to your use of the Service.</p>
      <p>e.Our Services are not directed to persons under 13. If you become aware that your child has provided us with personal information without your consent, please contact us. If Daily Magic become aware that a child under 13 has provided us with personal information, Daily Magic take steps to remove such information and terminate the child's account.</p>
    </ul>

  <p>G.<strong>Your Content and Conduct</strong></p>
    <ul>
      <p>a.As a Daily Magic account holder you may submit texts, likes and user comments. You understand that Daily Magic does not guarantee any confidentiality with respect to any Content you submit.</p>
      <p>b.You shall be solely responsible for your own Content and the consequences of submitting and publishing your Content on the Service. You affirm, represent, and warrant that you own or have the necessary licenses, rights, consents, and permissions to publish Content you submit; and you  pursuant to these Terms of Service.</p>
      <p>c. license to Daily Magic all patent, trademark, trade secret, copyright or other proprietary rights in and to such Content for publication on the Servicec.By submitting Content to Daily Magic, you hereby grant Daily Magic  a worldwide, non-exclusive, royalty-free, sub-licensable and transferable license to use, reproduce, distribute, display, publish, adapt, make available online or electronically transmit, and perform the Content in connection with the Service and Daily Magic 's (and its successors' and affiliates') business, in any media formats and through any media channels. You also hereby grant each user of the Service a non-exclusive license to access your Content through the Service, and to use, reproduce, distribute, display, publish, make available online or electronically transmit, and perform such Content as permitted through the functionality of the Service and under these Terms of Service. The above licenses granted by you in user comments you submit are perpetual and irrevocable.</p>
      <p>d.You further agree that Content you submit to the Service will not contain third party copyrighted material, or material that is subject to other third party proprietary rights, unless you have permission from the rightful owner of the material or you are otherwise legally entitled to post the material and to grant Daily Magic all of the license rights granted herein.</p>
      <p>e.You further agree that you will not submit any Content or comment etc. contrary to applicable local, national, and international laws and regulations.</p>
      <p>f.Daily Magic does not endorse any Content/comment etc. submitted to the Service by any user or other licensor, or any opinion, recommendation, or advice expressed therein, and Daily Magic expressly disclaims any and all liability in connection with Content. Daily Magic does not permit copyright infringing activities and infringement of intellectual property rights on the Service, and Daily Magic will remove all Content if properly notified that such Content infringes on another's intellectual property rights. Daily Magic reserves the right to remove Content without prior notice.</p>
    </ul>

  <p>H.<strong>Account Termination Policy</strong></p>
    <ul>
      <p>A.Daily Magic will terminate a user's access to the Service if, under appropriate circumstances, the user is determined to be a repeat infringer.</p>
      <p>B.Daily Magic reserves the right to decide whether Content violates these Terms of Service for reasons other than copyright infringement, such as, but not limited to, pornography, obscenity, or excessive length. Daily Magic may at any time, without prior notice and in its sole discretion, remove such Content and/or terminate a user's account for submitting such material in violation of these Terms of Service.</p>
    </ul>
  <p>I.<strong>Copyright Policy</strong> - As part of Daily Magic's copyright policy, Daily Magic will terminate user access to the Website if a user has been determined to be an infringer. An infringer is a user who has been notified of infringing activity.</p>
  <p>J.<strong>Warranty Disclaimer</strong></p>
  <p>YOU AGREE THAT YOUR USE OF THE SERVICES SHALL BE AT YOUR SOLE RISK. TO THE FULLEST EXTENT PERMITTED BY LAW, Daily Magic, ITS OFFICERS, DIRECTORS, EMPLOYEES, AND AGENTS EXCLUDE ALL WARRANTIES, EXPRESS OR IMPLIED, IN CONNECTION WITH THE SERVICES AND YOUR USE THEREOF. TO THE FULLEST EXTENT PERMITTED BY LAW, Daily Magic  EXCLUDES ALL WARRANTIES, CONDITIONS, TERMS OR REPRESENTATIONS ABOUT THE ACCURACY OR COMPLETENESS OF THIS SITE'S CONTENT OR THE CONTENT OF ANY SITES LINKED TO THIS SITE AND ASSUMES NO LIABILITY OR RESPONSIBILITY FOR ANY (I) ERRORS, MISTAKES, OR INACCURACIES OF CONTENT, (II) PERSONAL INJURY OR PROPERTY DAMAGE, OF ANY NATURE WHATSOEVER, RESULTING FROM YOUR ACCESS TO AND USE OF OUR SERVICES, (III) ANY UNAUTHORIZED ACCESS TO OR USE OF OUR SECURE SERVERS AND/OR ANY AND ALL PERSONAL INFORMATION AND/OR FINANCIAL INFORMATION STORED THEREIN, (IV) ANY INTERRUPTION OR CESSATION OF TRANSMISSION TO OR FROM OUR SERVICES, (IV) ANY BUGS, VIRUSES, TROJAN HORSES, OR THE LIKE WHICH MAY BE TRANSMITTED TO OR THROUGH OUR SERVICES BY ANY THIRD PARTY, AND/OR (V) ANY ERRORS OR OMISSIONS IN ANY CONTENT OR FOR ANY LOSS OR DAMAGE OF ANY KIND INCURRED AS A RESULT OF THE USE OF ANY CONTENT POSTED, EMAILED, TRANSMITTED, OR OTHERWISE MADE AVAILABLE VIA THE SERVICES. Daily Magic DOES NOT WARRANT, ENDORSE, GUARANTEE, OR ASSUME RESPONSIBILITY FOR ANY PRODUCT OR SERVICE ADVERTISED OR OFFERED BY A THIRD PARTY THROUGH THE SERVICES OR ANY HYPERLINKED SERVICES OR FEATURED IN ANY BANNER OR OTHER ADVERTISING, AND Daily Magic WILL NOT BE A PARTY TO OR IN ANY WAY BE RESPONSIBLE FOR MONITORING ANY TRANSACTION BETWEEN YOU AND THIRD-PARTY PROVIDERS OF PRODUCTS OR SERVICES. AS WITH THE PURCHASE OF A PRODUCT OR SERVICE THROUGH ANY MEDIUM OR IN ANY ENVIRONMENT, YOU SHOULD USE YOUR BEST JUDGMENT AND EXERCISE CAUTION WHERE APPROPRIATE.</p>
  <p>K.<strong>Limitation of Liability</strong></p>
  <p>TO THE FULLEST EXTENT PERMITTED BY LAW, IN NO EVENT SHALL Daily Magic , ITS OFFICERS, DIRECTORS, EMPLOYEES, OR AGENTS, BE LIABLE TO YOU FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, PUNITIVE, LOSSES OR EXPENSES OR CONSEQUENTIAL DAMAGES WHATSOEVER RESULTING FROM ANY (I) ERRORS, MISTAKES, OR INACCURACIES OF CONTENT, (II) PERSONAL INJURY OR PROPERTY DAMAGE, OF ANY NATURE WHATSOEVER, RESULTING FROM YOUR ACCESS TO AND USE OF OUR SERVICES, (III) ANY UNAUTHORIZED ACCESS TO OR USE OF OUR SECURE SERVERS AND/OR ANY AND ALL PERSONAL INFORMATION AND/OR FINANCIAL INFORMATION STORED THEREIN, (IV) ANY INTERRUPTION OR CESSATION OF TRANSMISSION TO OR FROM OUR SERVICES, (IV) ANY BUGS, VIRUSES, TROJAN HORSES, OR THE LIKE, WHICH MAY BE TRANSMITTED TO OR THROUGH OUR SERVICES BY ANY THIRD PARTY, AND/OR (V) ANY ERRORS OR OMISSIONS IN ANY CONTENT OR FOR ANY LOSS OR DAMAGE OF ANY KIND INCURRED AS A RESULT OF YOUR USE OF ANY CONTENT POSTED, EMAILED, TRANSMITTED, OR OTHERWISE MADE AVAILABLE VIA THE SERVICES, WHETHER BASED ON WARRANTY, CONTRACT, TORT, OR ANY OTHER LEGAL THEORY, AND WHETHER OR NOT THE COMPANY IS ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.
    WE UNDERSTAND THAT, IN SOME JURISDICTIONS, WARRANTIES, DISCLAIMERS AND CONDITIONS MAY APPLY THAT CANNOT BE LEGALLY EXCLUDED, IF THAT IS TRUE IN YOUR JURISDICTION, THEN TO THE EXTENT PERMITTED BY LAW, Daily Magic  LIMITS ITS LIABILITY FOR ANY CLAIMS UNDER THOSE WARRANTIES OR CONDITIONS TO EITHER SUPPLYING YOU THE SERVICES AGAIN (OR THE COST OF SUPPLYING YOU THE SERVICES AGAIN).
    YOU SPECIFICALLY ACKNOWLEDGE THAT Daily Magic SHALL NOT BE LIABLE FOR CONTENT OR THE DEFAMATORY, OFFENSIVE, OR ILLEGAL CONDUCT OF ANY THIRD PARTY AND THAT THE RISK OF HARM OR DAMAGE FROM THE FOREGOING RESTS ENTIRELY WITH YOU.</p>
  <p>The Service is controlled and offered by Daily Magic from its facilities in the India. Daily Magic makes no representations that the Service is appropriate or available for use in other locations. Those who access or use the Service from other jurisdictions do so at their own volition and are responsible for compliance with local law.</p>
  <p>L.<strong>Indemnity</strong></p>
  <p>To the extent permitted by applicable law, you agree to defend, indemnify and hold harmless Daily Magic, its parent corporation, officers, directors, employees and agents, from and against any and all claims, damages, obligations, losses, liabilities, costs or debt, and expenses (including but not limited to attorney's fees) arising from: (i) your use of and access to the Service; (ii) your violation of any term of these Terms of Service; (iii) your violation of any third party right, including without limitation any copyright, property, or privacy right; or (iv) any claim that your Content caused damage to a third party. This defense and indemnification obligation will survive these Terms of Service and your use of the Service.</p>
  <p>M.<strong>Ability to Accept Terms of Service</strong></p>
  <p>You affirm that you are either more than 18 years of age, or an emancipated minor, or possess legal parental or guardian consent, and are fully able and competent to enter into the terms, conditions, obligations, affirmations, representations, and warranties set forth in these Terms of Service, and to abide by and comply with these Terms of Service. In any case, you affirm that you are over the age of 13, as the Service is not intended for children under 13. If you are under 13 years of age, then please do not use the Service. We provide these Terms of Service with our Service so that you know what terms apply to your use. You acknowledge that we have given you a reasonable opportunity to review these Terms of Service and that you have agreed to them.</p>
  <p>N.<strong>Assignment</strong></p>
  <p>These Terms of Service, and any rights and licenses granted hereunder, may not be transferred or assigned by you, but may be assigned by Daily Magic  without restriction.</p>
  <p>O.<strong>General</strong></p>
  <p>You agree that: (i) the Service shall be deemed solely based in India; and (ii) the Service shall be deemed a passive website that does not give rise to personal jurisdiction over Daily Magic, either specific or general, in jurisdictions other than India. You agree that the laws of India will apply to these Terms of Service. In addition, for any dispute arising out of or related to the Service, the parties consent to personal jurisdiction in, and exclusive venue of, the courts in Mumbai, India. These Terms of Service, together with the Privacy Notice and any other legal notices published by Daily Magic on the Service, shall constitute the entire agreement between you and Daily Magic concerning the Service. If it turns out that a particular term is not enforceable, this will not affect any other terms. No waiver of any term of this Terms of Service shall be deemed a further or continuing waiver of such term or any other term, and Daily Magic's failure to assert any right or provision under these Terms of Service shall not constitute a waiver of such right or provision. </p>
  <p><strong>Dated: 10th April, 2015</strong></p>
</ul>
</div>
		</td>
	</tr>
	<tr>
		<td height="40" align="center">
			<?php if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){  ?>			
			<?php }elseif($USERSTATUS != 'PENDING'){ ?>
			<center><a href="unsubscribe.php">Click Here to Unsubscribe</a></center>
			<?php } ?>
			
			</a>
		</td>
	</tr>
<?php
include 'portlets/footer.php';
?>
</body>
 </html>