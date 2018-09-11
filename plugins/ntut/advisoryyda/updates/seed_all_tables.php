<?php namespace Ntut\AdvisoryYda\Updates;

use Carbon\Carbon;
use RainLab\User\Models\User;
use October\Rain\Database\Updates\Seeder;
use Esroyo\UserProfile\Models\Settings;
use RainLab\Blog\Models\Category;
use FireUnion\BlogFront\Models\Author;
use Backend\Models\User as Admin;
use RainLab\Blog\Models\Post;
use Db;

class SeedAllTables extends Seeder
{
    public function run()
    {
        $admin = Admin::find(1);

        $wang = User::create([
            'name' => '王委員',
            'surname' => '王委員',
            'email' => 'wang@test.com',
            'password' => '12345',
            'password_confirmation' => '12345',
            'is_activated' => 1,
            'activated_at' => Carbon::now(),
            'username' => 'wang@test.com'
        ]);

        $chang = User::create([
            'name' => '張委員',
            'surname' => '張委員',
            'email' => 'chang@test.com',
            'password' => '12345',
            'password_confirmation' => '12345',
            'is_activated' => 1,
            'activated_at' => Carbon::now(),
            'username' => 'chang@test.com'
        ]);

        $chen = User::create([
            'name' => '陳委員',
            'surname' => '陳委員',
            'email' => 'chen@test.com',
            'password' => '12345',
            'password_confirmation' => '12345',
            'is_activated' => 1,
            'activated_at' => Carbon::now(),
            'username' => 'chen@test.com'
        ]);

        Category::find(1)->delete();
        Category::create(['name' => '大會提案','slug' => 'proposal']);
        Category::create(['name' => '文章類','slug' => 'article']);
        Category::create(['name' => '活動','slug' => 'activity']);
        Category::create(['name' => '會議','slug' => 'meeting']);

        $author_wang = Author::create([
            'user' => $wang,
            'admin_id' => 1,
            'categories' => ["3"],
            'can_publish' => true,
            'allow_images' => true,
            'note' => ''
        ]);

        Author::create([
            'user' => $chen,
            'admin_id' => 1,
            'categories' => ["3"],
            'can_publish' => true,
            'allow_images' => true,
            'note' => ''
        ]);

        Author::create([
            'user' => $chang,
            'admin_id' => 1,
            'categories' => ["3"],
            'can_publish' => true,
            'allow_images' => true,
            'note' => ''
        ]);
        
        Post::find(1)->delete();
        Post::create([
            'user_id' => 1,
            'author_id' => 1,
            'title' => '英公平境適自的中方一布發s友',
            'slug' => 'f335a09ce7acs7c2bassdfsddfsd7c99721058053cf',
            'published' => true,
            'published_at' => Carbon::now(),
            'content' => '
# **英公平境適自的中方一布發友**

走居到。自前背小對實發管幾個我，應樂現顯投？

手成運進、綠那術、新里讀！斷謝精、計政什為毛作，美告近人以雄講相會子笑成代談教天，風然前大寫決者所可生就數又總合和義視會價大，倒大市門，美否外車……的打兩，第師父天起，品真在？仍讓感後有了營其間外我早個都是生國全的著還打、笑東示之媽主後不字著局；性知這；住然能已實的望上先幾做圖身的：火以人感，好會次，了路畫腦化少裡長的英？清陸人日影。

點日東點難金以手這生玩正時得於教是真活影會件文質以通創好來定外是洋就說整地力房溫領樂什公沒：讓每是認不？縣至間何國集頭面行德減位交……於開計聲而最家安星政以來爾頭而小那北問飛下會之物成華線向了灣新東成動力看的們熱與時樂線系而兒國內加至他，林在身國候後：上經於正一起曾黃時美們然：對公立價先會接？以工克出計力線了來身是書得在開認高軍，經細之線足身……法是傳臺同苦業活，爸環業！以公天以！到臺眼回，那兩時法生應風股神？急健花。

房例印！我色去裡常了感顯公話什，可情境。

大野告地強形公了。

多直我洲著不市得向流日我五生提身！部開再想它式有我問黃當；一高神速。稱則同同寫！年比去片年……多命斷他氣雖說也覺字四傷中學，算買可級一生衣操，文是學個形是道都基方初官心作天笑，排局自息日亞極古推只方民神爸據情的？孩眾系布，賣乎看衣到一，力心我都心月什到。一場沒清成天過了的的聞也無會做教子就然活當的你。

雜得算也？關青可開高石喜紙心是高的地起等坐藝國……總心期南市電頭許是做微拉也，光太會最司確面統問到地關，的了市以臺道本下化究復得帶火選名況房客音書味片氣過亞成了，日白際高個意門要的國查、裡金利經讀我山，是停他！

領坐一喜精陽公路奇病須格士生天賽結味……能價可傷學家刻質三，招火今條……更復何戰寫大必性地能子去出倒一影唱體話收假相帶，好臺子變在越和法師開好獲正清所差經人學長以，克間在程問朋？作最格之同等很的下畫不打、好上字集同爾我種家解靜的家校讀防演人怕背統試，立真食時成下公女聲樣、再法但減早另人家是很我同風相打獎如感開時……了消眾！完表。

加的們著入放有；專才手力線情灣蘭親了吃們長子車高士說力發腦先一消，要可說影他與林別念靜水兩推創題來也幾！的心出該死題立演地像選的舞，自際海，們化院成！以動報問備此中電基治，老生則是獎風後上經上太改路，口就東常了行業通不為印給色角價學，以紀理快，為神然布謝始史究它不示舉一社聽盡發；一子港友神言決視加生正背；開收當；成推例作病兩那，們女上母不己孩人有排不，代氣兒。產頭們政不樣本電大打超義。親觀反、五要回司情候，術標正線的母讀花屋化；童現臺雄展火母象不性示濟，會充性易性後然安成合有、這像答來。作看女出待要與品能代在老。美及種！部黨天灣人實他部臺格放想張英給要實那表話臺、軍北一水是是場麼三了動活更國用聲見自們麼：人銀又物上亮富花之是量著懷國百點！
            ',
            'content_html' => '<h1><strong>英公平境適自的中方一布發友</strong></h1> <p>走居到。自前背小對實發管幾個我，應樂現顯投？</p> <p>手成運進、綠那術、新里讀！斷謝精、計政什為毛作，美告近人以雄講相會子笑成代談教天，風然前大寫決者所可生就數又總合和義視會價大，倒大市門，美否外車……的打兩，第師父天起，品真在？仍讓感後有了營其間外我早個都是生國全的著還打、笑東示之媽主後不字著局；性知這；住然能已實的望上先幾做圖身的：火以人感，好會次，了路畫腦化少裡長的英？清陸人日影。</p> <p>點日東點難金以手這生玩正時得於教是真活影會件文質以通創好來定外是洋就說整地力房溫領樂什公沒：讓每是認不？縣至間何國集頭面行德減位交……於開計聲而最家安星政以來爾頭而小那北問飛下會之物成華線向了灣新東成動力看的們熱與時樂線系而兒國內加至他，林在身國候後：上經於正一起曾黃時美們然：對公立價先會接？以工克出計力線了來身是書得在開認高軍，經細之線足身……法是傳臺同苦業活，爸環業！以公天以！到臺眼回，那兩時法生應風股神？急健花。</p> <p>房例印！我色去裡常了感顯公話什，可情境。</p> <p>大野告地強形公了。</p> <p>多直我洲著不市得向流日我五生提身！部開再想它式有我問黃當；一高神速。稱則同同寫！年比去片年……多命斷他氣雖說也覺字四傷中學，算買可級一生衣操，文是學個形是道都基方初官心作天笑，排局自息日亞極古推只方民神爸據情的？孩眾系布，賣乎看衣到一，力心我都心月什到。一場沒清成天過了的的聞也無會做教子就然活當的你。</p> <p>雜得算也？關青可開高石喜紙心是高的地起等坐藝國……總心期南市電頭許是做微拉也，光太會最司確面統問到地關，的了市以臺道本下化究復得帶火選名況房客音書味片氣過亞成了，日白際高個意門要的國查、裡金利經讀我山，是停他！</p> <p>領坐一喜精陽公路奇病須格士生天賽結味……能價可傷學家刻質三，招火今條……更復何戰寫大必性地能子去出倒一影唱體話收假相帶，好臺子變在越和法師開好獲正清所差經人學長以，克間在程問朋？作最格之同等很的下畫不打、好上字集同爾我種家解靜的家校讀防演人怕背統試，立真食時成下公女聲樣、再法但減早另人家是很我同風相打獎如感開時……了消眾！完表。</p> <p>加的們著入放有；專才手力線情灣蘭親了吃們長子車高士說力發腦先一消，要可說影他與林別念靜水兩推創題來也幾！的心出該死題立演地像選的舞，自際海，們化院成！以動報問備此中電基治，老生則是獎風後上經上太改路，口就東常了行業通不為印給色角價學，以紀理快，為神然布謝始史究它不示舉一社聽盡發；一子港友神言決視加生正背；開收當；成推例作病兩那，們女上母不己孩人有排不，代氣兒。產頭們政不樣本電大打超義。親觀反、五要回司情候，術標正線的母讀花屋化；童現臺雄展火母象不性示濟，會充性易性後然安成合有、這像答來。作看女出待要與品能代在老。美及種！部黨天灣人實他部臺格放想張英給要實那表話臺、軍北一水是是場麼三了動活更國用聲見自們麼：人銀又物上亮富花之是量著懷國百點！</p>',
            'categories' => [3],
            'level' => 1
        ]);

        Post::create([
            'user_id' => 1,
            'title' => '第一次青年諮詢委員會',
            'slug' => '1',
            'published' => true,
            'published_at' => Carbon::now(),
            'content' => '
**壹、主席致詞**
 
**貳、頒發聘書**

**參、委員自我介紹**

**肆、提案與討論**

**伍、主席回應與結論**

一、「行政院青年諮詢委員會」（以下簡稱青諮會）為行政團隊與青年朋友溝通、交換意見的平臺，並非邀請委員為公共政策背書，而是讓不同領域中有見解與想法的年輕人，大膽嘗試從各種觀點提出建言，讓政府瞭解政策需要加強與改善之處。

二、有關青年代表擔任之委員（以下簡稱青年委員）相互推選第2位「副召集人」票選結果，由黃委員敬峰當選（獲12票）。

三、有關政府計畫公開部分，本院未來將規劃串接「KMPublic」及「公共政策網路參與平臺」的功能，讓大家有機會針對各項子計畫或議題進行實質的討論與分享。

四、有關94年以來「青年發展法」草案的3個不同版本之委託研究成果，請教育部綜合盤點後提供委員參考。

五、對某項議題感興趣的委員，可以連署（至少3人）後自行組成一個分組，並邀相關部會代表參與，以產出至少一份施政建議文件為目標。

六、請幕僚單位協助於會後函請各部會盤點哪些會議可讓青年委員出席參加，以利青年委員瞭解政策議題。

陸、散會(下午5時30分)
行政院青年諮詢委員會第1次會議紀錄

逐字稿連結
            ',
            'content_html' => '<p><strong>壹、主席致詞</strong></p> <p><strong>貳、頒發聘書</strong></p> <p><strong>參、委員自我介紹</strong></p> <p><strong>肆、提案與討論</strong></p> <p><strong>伍、主席回應與結論</strong></p> <p>一、「行政院青年諮詢委員會」（以下簡稱青諮會）為行政團隊與青年朋友溝通、交換意見的平臺，並非邀請委員為公共政策背書，而是讓不同領域中有見解與想法的年輕人，大膽嘗試從各種觀點提出建言，讓政府瞭解政策需要加強與改善之處。</p> <p>二、有關青年代表擔任之委員（以下簡稱青年委員）相互推選第2位「副召集人」票選結果，由黃委員敬峰當選（獲12票）。</p> <p>三、有關政府計畫公開部分，本院未來將規劃串接「KMPublic」及「公共政策網路參與平臺」的功能，讓大家有機會針對各項子計畫或議題進行實質的討論與分享。</p> <p>四、有關94年以來「青年發展法」草案的3個不同版本之委託研究成果，請教育部綜合盤點後提供委員參考。</p> <p>五、對某項議題感興趣的委員，可以連署（至少3人）後自行組成一個分組，並邀相關部會代表參與，以產出至少一份施政建議文件為目標。</p> <p>六、請幕僚單位協助於會後函請各部會盤點哪些會議可讓青年委員出席參加，以利青年委員瞭解政策議題。</p> <p>陸、散會(下午5時30分) 行政院青年諮詢委員會第1次會議紀錄</p> <p>逐字稿連結</p>',
            'categories' => [5],
            'level' => 1
        ]);
        
        Db::table('rainlab_blog_user_post')->insert([
            ['user_id' => 1,'post_id' => 3],
            ['user_id' => 2,'post_id' => 3],
            ['user_id' => 3,'post_id' => 3]
        ]);

        $settings = Settings::instance();
        $settings->value = json_decode('{"profile_field":[{"name":"headline","type":"text","label":"headline","comment":"","tab":"Profile","span":"left","required":"0"},{"name":"facebook","type":"text","label":"facebook","comment":"","tab":"Profile","span":"right","required":"0"},{"name":"instagram","type":"text","label":"Instagram","comment":"","tab":"Profile","span":"right","required":"0"},{"name":"twitter","type":"text","label":"twitter","comment":"","tab":"Profile","span":"left","required":"0"},{"name":"website","type":"text","label":"website","comment":"","tab":"Profile","span":"left","required":"0"},{"name":"expertises","type":"text","label":"expertises","comment":"","tab":"Profile","span":"right","required":"0"},{"name":"interested_topics","type":"textarea","label":"interested_topics","comment":"","tab":"Profile","span":"full","required":"0"},{"name":"about_me","type":"textarea","label":"about_me","comment":"","tab":"Profile","span":"full","required":"0"}]}',true);
        $settings->save();
    }
}