<?php

namespace Modules\LandingPage\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\LandingPage\Entities\LandingPageSetting;

class LandingPageDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        $data['topbar_status'] = 'off';
        $data['topbar_notification_msg'] = 'Offer Starts Soon.....';

        $data['menubar_status'] = 'on';
        $data['menubar_page'] = '[{"menubar_page_name":"About Us","menubar_page_contant":"<div>\r\n<div>Welcome to Connectiv, your trusted partner in the world of technology. We are an innovative IT company dedicated to providing cutting-edge solutions and services to help businesses thrive in the digital age. With a team of highly skilled professionals and a passion for technology, we strive to deliver exceptional results that drive growth and transform businesses.<\/div>\r\n<br>\r\n<div>At Connectiv, we believe that technology should be an enabler, not a barrier. We work closely with our clients to understand their unique needs and challenges, and then tailor our solutions to meet their specific requirements. Whether you are a small startup or a large enterprise, we have the expertise and experience to deliver scalable and cost-effective IT solutions that align with your business goals.<\/div>\r\n<br>\r\n<div>Our comprehensive range of services includes software development, web and mobile app development, cloud computing, cybersecurity, IT consulting, and more. We leverage the latest technologies and industry best practices to ensure that our clients stay ahead of the competition and achieve long-term success.<\/div>\r\n<br>\r\n<div>With a customer-centric approach, we prioritize communication, collaboration, and transparency throughout every project. We believe in building strong and lasting relationships with our clients, and we go the extra mile to exceed their expectations. Your success is our success, and we are committed to helping you unlock your full potential through technology.<\/div>\r\n<br>\r\n<div>Choose Connectiv as your technology partner and experience the power of innovation, reliability, and expertise. Contact us today to discuss your IT needs and let us embark on a journey towards digital transformation together.<\/div>\r\n<\/div>","page_slug":"about_us","header":"on","footer":"on"},{"menubar_page_name":"Terms and Conditions","menubar_page_contant":"<div>\r\n<div>Welcome to the Connectiv website. By accessing this website, you agree to comply with and be bound by the following terms and conditions of use. If you disagree with any part of these terms, please do not use our website.<\/div>\r\n<br>\r\n<div>The content of the pages of this website is for your general information and use only. It is subject to change without notice.<\/div>\r\n<br>\r\n<div>This website uses cookies to monitor browsing preferences. If you do allow cookies to be used, personal information may be stored by us for use by third parties.<\/div>\r\n<br>\r\n<div>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness, or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors, and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.<\/div>\r\n<br>\r\n<div>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services, or information available through this website meet your specific requirements.<\/div>\r\n<br>\r\n<div>This website contains material that is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance, and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.<\/div>\r\n<br>\r\n<div>Unauthorized use of this website may give rise to a claim for damages and\/or be a criminal offense.<\/div>\r\n<br>\r\n<div>From time to time, this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).<\/div>\r\n<\/div>","page_slug":"terms_and_conditions","header":"off","footer":"on"},{"menubar_page_name":"Privacy Policy","menubar_page_contant":"<div>\r\n<div><strong>Introduction:<\/strong> An overview of the privacy policy, including the purpose and scope of the policy.<\/div>\r\n<br>\r\n<div><strong>Information Collection:<\/strong> Details about the types of information collected from users\/customers, such as personal information (name, address, email), device information, usage data, and any other relevant data.<\/div>\r\n<br>\r\n<div><strong>Data Usage: <\/strong>An explanation of how the collected data will be used, including providing services, improving products, personalization, analytics, and any other legitimate business purposes.<\/div>\r\n<br>\r\n<div><strong>Data Sharing:<\/strong> Information about whether and how the company shares user data with third parties, such as partners, service providers, or affiliates, along with the purposes of such sharing.<\/div>\r\n<br>\r\n<div><strong>Data Security: <\/strong>Details about the measures taken to protect user data from unauthorized access, loss, or misuse, including encryption, secure protocols, access controls, and data breach notification procedures.<\/div>\r\n<br>\r\n<div><strong>User Choices:<\/strong> Information on the choices available to users regarding the collection, use, and sharing of their personal data, including opt-out mechanisms and account settings.<\/div>\r\n<br>\r\n<div><strong>Cookies and Tracking Technologies:<\/strong> Explanation of the use of cookies, web beacons, and similar technologies for tracking user activity and collecting information for analytics and advertising purposes.<\/div>\r\n<br>\r\n<div><strong>Third-Party Links:<\/strong> Clarification that the companys website or services may contain links to third-party websites or services and that the privacy policy does not extend to those external sites.<\/div>\r\n<br>\r\n<div><strong>Data Retention:<\/strong> Details about the retention period for user data and how long it will be stored by the company.<\/div>\r\n<br>\r\n<div><strong>Legal Basis and Compliance:<\/strong> Information about the legal basis for processing personal data, compliance with applicable data protection laws, and the rights of users under relevant privacy regulations (e.g., GDPR, CCPA).<\/div>\r\n<br>\r\n<div><strong>Updates to the Privacy Policy:<\/strong> Notification that the privacy policy may be updated from time to time, and how users will be informed of any material changes.<\/div>\r\n<br>\r\n<div><strong>Contact Information:<\/strong> How users can contact the company regarding privacy-related concerns or inquiries.<\/div>\r\n<\/div>","page_slug":"privacy_policy","header":"off","footer":"on"}]';

        $data['site_logo'] = 'site_logo.png';
        $data['site_description'] = 'We build modern web tools to help you jump-start your daily business work.';
        $data['home_status'] = 'on';
        $data['home_offer_text'] = 'No Special Offer';
        $data['home_title'] = 'Home';
        $data['home_heading'] = 'Connectiv - HRM and Payroll Tool';
        $data['home_description'] = 'Use this awesome site to make your HR Operations go Smoother';
        $data['home_trusted_by'] = '100+ Customer';
        $data['home_live_demo_link'] = 'https://demo.connectiv.com';
        $data['home_buy_now_link'] = 'https://connectiv.vemsgroup.in';
        $data['home_banner'] = 'home_banner.png';
        $data['home_logo'] = 'home_logo.png';

        $data['feature_status'] = 'on';
        $data['feature_title'] = 'Features';
        $data['feature_heading'] = 'All In One Place CRM System';
        $data['feature_description'] = 'Use this awesome site to make your HR Operations go Smoother Use this awesome site to make your HR Operations go Smoother';
        $data['feature_buy_now_link'] = 'https://connectiv.vemsgroup.in';
        $data['feature_of_features'] = '[{"feature_logo":"1686575690-feature_logo.png","feature_heading":"Feature","feature_description":"<p>Use this awesome site to make your HR Operations go SmootherUse this awesome site to make your HR Operations go Smoother<\/p>"},{"feature_logo":"1686545757-feature_logo.png","feature_heading":"Support","feature_description":"Use this awesome site to make your HR Operations go SmootherUse this awesome site to make your HR Operations go Smoother"},{"feature_logo":"1686546152-feature_logo.png","feature_heading":"Integration","feature_description":"Use this awesome site to make your HR Operations go SmootherUse this awesome site to make your HR Operations go Smoother"}]';

        $data['highlight_feature_heading'] = 'Connectiv - HRM and Payroll Tool';
        $data['highlight_feature_description'] = 'Use this awesome site to make your HR Operations go Smoother';
        $data['highlight_feature_image'] = 'highlight_feature_image.png';
        $data['other_features'] = '[{"other_features_image":"1688375380-other_features_image.png","other_features_heading":"Connectiv - HRM and Payroll Tool","other_featured_description":"<p>Use this awesome site to make your HR Operations go Smoother<\/p>","other_feature_buy_now_link":"https:\/\/codecanyon.net\/item\/Connectiv-hrm-and-payroll-tool\/25982864"},{"other_features_image":"1688375397-other_features_image.png","other_features_heading":"Connectiv - HRM and Payroll Tool","other_featured_description":"<p>Use this awesome site to make your HR Operations go Smoother<\/p>","other_feature_buy_now_link":"https:\/\/codecanyon.net\/item\/Connectiv-hrm-and-payroll-tool\/25982864"},{"other_features_image":"1688375413-other_features_image.png","other_features_heading":"Connectiv - HRM and Payroll Tool","other_featured_description":"<p>Use this awesome site to make your HR Operations go Smoother<\/p>","other_feature_buy_now_link":"https:\/\/codecanyon.net\/item\/Connectiv-hrm-and-payroll-tool\/25982864"},{"other_features_image":"1688375429-other_features_image.png","other_features_heading":"Connectiv - HRM and Payroll Tool","other_featured_description":"<p>Use this awesome site to make your HR Operations go Smoother<\/p>","other_feature_buy_now_link":"https:\/\/codecanyon.net\/item\/Connectiv-hrm-and-payroll-tool\/25982864"}]';

        $data['discover_status'] = 'on';
        $data['discover_heading'] = 'Connectiv - HRM and Payroll Tool';
        $data['discover_description'] = 'Use this awesome site to make your HR Operations go Smoother';
        $data['discover_live_demo_link'] = 'https://demo.connectiv.com';
        $data['discover_buy_now_link'] = 'https://connectiv.vemsgroup.in';
        $data['discover_of_features'] = '[{"discover_logo":"1686575797-discover_logo.png","discover_heading":"Feature","discover_description":"<p>Use this awesome site to make your HR Operations go SmootherUse this awesome site to make your HR Operations go Smoother<\/p>"},{"discover_logo":"1686547242-discover_logo.png","discover_heading":"Feature","discover_description":"Use this awesome site to make your HR Operations go SmootherUse this awesome site to make your HR Operations go Smoother"},{"discover_logo":"1686547625-discover_logo.png","discover_heading":"Feature","discover_description":"Use this awesome site to make your HR Operations go SmootherUse this awesome site to make your HR Operations go Smoother"},{"discover_logo":"1686547638-discover_logo.png","discover_heading":"Feature","discover_description":"Use this awesome site to make your HR Operations go SmootherUse this awesome site to make your HR Operations go Smoother"},{"discover_logo":"1686547653-discover_logo.png","discover_heading":"Feature","discover_description":"Use this awesome site to make your HR Operations go SmootherUse this awesome site to make your HR Operations go Smoother"},{"discover_logo":"1686547662-discover_logo.png","discover_heading":"Feature","discover_description":"Use this awesome site to make your HR Operations go SmootherUse this awesome site to make your HR Operations go Smoother"},{"discover_logo":"1686547709-discover_logo.png","discover_heading":"Feature","discover_description":"Use this awesome site to make your HR Operations go SmootherUse this awesome site to make your HR Operations go Smoother"},{"discover_logo":"1686547717-discover_logo.png","discover_heading":"Feature","discover_description":"Use this awesome site to make your HR Operations go SmootherUse this awesome site to make your HR Operations go Smoother"}]';

        $data['screenshots_status'] = 'on';
        $data['screenshots_heading'] = 'Connectiv - HRM and Payroll Tool';
        $data['screenshots_description'] = 'Use this awesome site to make your HR Operations go Smoother';
        $data['screenshots'] = '[{"screenshots":"1688375477-screenshots.png","screenshots_heading":"HRM Dashboard"},{"screenshots":"1688451632-screenshots.png","screenshots_heading":"User Roles"},{"screenshots":"1688451623-screenshots.png","screenshots_heading":"Profile Overview"},{"screenshots":"1688375508-screenshots.png","screenshots_heading":"HRM Users"},{"screenshots":"1688451675-screenshots.png","screenshots_heading":"Contract Page"},{"screenshots":"1688451692-screenshots.png","screenshots_heading":"Job Career"}]';

        $data['faq_status'] = 'on';
        $data['faq_title'] = 'Faq';
        $data['faq_heading'] = 'Connectiv - HRM and Payroll Tool';
        $data['faq_description'] = 'Use this awesome site to make your HR Operations go Smoother';
        $data['faqs'] = '[{"faq_questions":"#What does \"Theme\/Package Installation\" mean?","faq_answer":"For an easy-to-install theme\/package, we have included step-by-step detailed documentation (in English). However, if it is not done perfectly, please feel free to contact the support team at support@workdo.io"},{"faq_questions":"#What does \"Theme\/Package Installation\" mean?","faq_answer":"For an easy-to-install theme\/package, we have included step-by-step detailed documentation (in English). However, if it is not done perfectly, please feel free to contact the support team at support@workdo.io"},{"faq_questions":"#What does \"Lifetime updates\" mean?","faq_answer":"For an easy-to-install theme\/package, we have included step-by-step detailed documentation (in English). However, if it is not done perfectly, please feel free to contact the support team at support@workdo.io"},{"faq_questions":"#What does \"Lifetime updates\" mean?","faq_answer":"For an easy-to-install theme\/package, we have included step-by-step detailed documentation (in English). However, if it is not done perfectly, please feel free to contact the support team at support@workdo.io"},{"faq_questions":"# What does \"6 months of support\" mean?","faq_answer":"Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa\r\n                                    nesciunt\r\n                                    laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt\r\n                                    sapiente ea\r\n                                    proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven heard of them accusamus labore sustainable VHS."},{"faq_questions":"# What does \"6 months of support\" mean?","faq_answer":"Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa\r\n                                    nesciunt\r\n                                    laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt\r\n                                    sapiente ea\r\n                                    proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven heard of them accusamus labore sustainable VHS."}]';

        $data['testimonials_status'] = 'on';
        $data['testimonials_heading'] = 'From our Clients';
        $data['testimonials_description'] = 'Use this awesome site to make your HR Operations go Smoother';
        $data['testimonials_long_description'] = 'WorkDo seCommerce package offers you a “sales-ready.”secure online store. The package puts all the key pieces together, from design to payment processing. This gives you a headstart in your eCommerce venture. Every store is built using a reliable PHP framework -laravel. Thisspeeds up the development process while increasing the store’s security and performance.Additionally, thanks to the accompanying mobile app, you and your team can manage the store on the go. What’s more, because the app works both for you and your customers, you can use it to reach a wider audience.And, unlike popular eCommerce platforms, it doesn’t bind you to any terms and conditions or recurring fees. You get to choose where you host it or which payment gateway you use. Lastly, you getcomplete control over the looks of the store. And if it lacks any functionalities that you need, just reach out, and let’s discuss customization possibilities';
        $data['testimonials'] = '[{"testimonials_user_avtar":"1686634418-testimonials_user_avtar.jpg","testimonials_title":"Tbistone","testimonials_description":"Very quick customer support, installing this application on my machine locally, within 5 minutes of creating a ticket, the developer was able to fix the issue I had within 10 minutes. EXCELLENT! Thank you very much","testimonials_user":"Chordsnstrings","testimonials_designation":"from Vems","testimonials_star":"4"},{"testimonials_user_avtar":"1686634425-testimonials_user_avtar.jpg","testimonials_title":"Tbistone","testimonials_description":"Very quick customer support, installing this application on my machine locally, within 5 minutes of creating a ticket, the developer was able to fix the issue I had within 10 minutes. EXCELLENT! Thank you very much","testimonials_user":"Chordsnstrings","testimonials_designation":"from Vems","testimonials_star":"4"},{"testimonials_user_avtar":"1686634432-testimonials_user_avtar.jpg","testimonials_title":"Tbistone","testimonials_description":"Very quick customer support, installing this application on my machine locally, within 5 minutes of creating a ticket, the developer was able to fix the issue I had within 10 minutes. EXCELLENT! Thank you very much","testimonials_user":"Chordsnstrings","testimonials_designation":"from Vems","testimonials_star":"4"}]';

        $data['footer_status'] = 'on';
        $data['joinus_status'] = 'on';
        $data['joinus_heading'] = 'Join Our Community';
        $data['joinus_description'] = 'We build modern web tools to help you jump-start your daily business work.';


        foreach($data as $key => $value){
            if(!LandingPageSetting::where('name', '=', $key)->exists()){
                LandingPageSetting::updateOrCreate(['name' =>  $key],['value' => $value]);
            }
        }
    }
}