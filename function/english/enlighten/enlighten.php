<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
    <link rel='stylesheet' type='text/css' href='../../../lib/bootstrap-4.0.0/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='../../../lib/font-awesome-4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='../../../lib/video-js/css/video-js.min.css'>
    <script src='../../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../../lib/popper.min.js'></script>
    <script src='../../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
    <script src='../../../lib/common.js'></script>
    <script src='../../../lib/video-js/js/video.min.js'></script>
    <script src='../../../lib/video_js_setting.js'></script>
    <script src='./enlighten.js'></script>
    <link rel='stylesheet' type='text/css' href='../css/english.css'>
    <title>English</title>
    <script>
        var enlighten_info = [
            {
                title: "<code>家长必看前言</code>",
                title_eng: "",
                chn: "<ul>" +
                "<li>本内容来源于英语国家优质的语言启蒙教育理念，是我为教育自己的孩子总结出来一套适合中国孩子的学习方法。</li>" +
                "<li>即使你也是英语0基础也可以指导孩子一起使用本方法来进行英语启蒙，和孩子一起学习更能体会在学习过程中的一些问题。</li>" +
                "<li>请家长或老师花10分钟仔细理解预备知识后，因材施教，让孩子有一个好的起点。</li>" +
                "<li>如果你有好的想法，也可以给我建议：QQ_3476626837。</li>" +
                "<li>本站所有资源均可免费使用，但仅限于个人学习用途。</li>" +
                "<li>站内部分资源来源于网络，如有侵权，请联系我删除。</li>" +
                "</ul>",
                eng: ""
            },
            {
                title: "什么是自然拼读法",
                title_eng: "What is phonics",
                chn: "自然拼读法是一种通过培养学习者的音素意识来教授阅读和写作的方法。 拼读能力对帮助孩子开始阅读是绝对有必要的。 一旦阅读的单词通过拼读法进行了识别，孩子就具备了通篇探索文章的能力。 自然拼读法已经一次又一次证明是让孩子早读的最有效方法。",
                eng: "Phonics is a method for teaching reading and writing by developing learners’ phonemic awareness. Phonics is absolutely essential for helping children begin to read. Once the code of reading has been cracked through phonics, children will then have the ability to explore the length and breadth of literacy as a whole. Phonics has proven time and again to be the most effective way to get children reading early.",
                video_tab: {
                    tab_name: "视频",
                    callback: ["show_video", 21] // 第一个元素为函数名，第二个元素为函数参数
                }
            },
            {
                title: "自然拼读法为什么重要",
                title_eng: "Why is phonics important",
                chn: "自然拼读法可帮助您的孩子学习阅读和拼写（<code>即使在没有音标的情况下，也能准确的发音或根据发音写出对应的单词</code>）。没有这种能力，你的孩子就无法完全独立识字。 单词就像代码，而拼读法则教会孩子们如何去阅读代码。 因此，拼读法是任何阅读发展计划的重要组成部分。",
                eng: "Phonics helps your child learn to read and spell. Without this ability, your child cannot be fully literate. Words are like codes and phonics teaches children how to crack the reading code. Phonics is therefore an important part of any reading development program."
            },
            {
                title: "孩子从多大开始学",
                title_eng: "When is the best time to learn",
                chn: "自然拼读法最好的学习时机是从幼儿园开始到小学二年级，也就是从大约3岁到8岁。",
                eng: "It is often best to start learning to read through  phonics from preschool to 2nd grade or from about ages 3 to 8."
            },
            {
                title: "为什么要这么早学呢",
                title_eng: "Why start so early",
                chn: "研究表明，到二年级时没有发展阅读技能的孩子，在整个学习生活中会全面延迟学习。",
                eng: "Research has shown that children who have not developed reading skills by second grade, will experience an overall delay in learning throughout their school life."
            },
            {
                title: "作为家长应怎样辅导孩子",
                title_eng: "I am a parent. How can I help my child learn to read",
                chn: "一个孩子实际上是在家里开始学习读书的，而不是在学校。当然，老师在学校也会做这项工作，但即使有老师在学校帮助，孩子在父母参与学习时总会做得更好。每天给孩子留出20分钟的时间做一个语音课程，并且需要坚持下去。",
                eng: "A child actually begins to learn to read at home, not at school. Teachers finish the job at school. Even with teachers helping at school, children always do better when their parents are involved in their learning. Set aside as little as 20 minutes everyday to do a phonics lesson. Just keep it regular. "
            },
            {
                title: "什么是音素",
                title_eng: "What is a phoneme",
                chn: "音素是可区别发音的最小单位。 例如，在单词cat中，我们可以听到三个不同的音素[ k ] [ a ] [ t ]。 如果我们改变[ k ] [ a ] [ t ]到[ k ] [ a ] [ p ]这个单词的含义将会完全改变。因此，让孩子能够清楚地听到和辨别音素是非常重要的。<br>" +
                "如果还没理解什么是音素，我再用中文来举个例子：汉字【大】相信大家都会读，你读的时候是一个音，但它却是由两个音素组成的分别为<code>d</code>和<code>a</code>（注意这里是da是拼音）。",
                eng: "A phoneme is the smallest unit of sound that can differentiate meaning. For example, in the word cat, we can hear three distinct phonemes /k/ /a/ /t/. If we change /k/ /a/ /t/ to /k/ /a/ /p/ the meaning of the word will change completely. Therefore, it is very important for children to be able to clearly hear and distinguish phonemes. "
            },
            {
                title: "什么是音素意识",
                title_eng: "What is phonemic awareness",
                chn: "音素意识是能够听出和组合单个音素。 音素意识是识别一个单词里的每个单独的发音。",
                eng: "Phonemic awareness is the ability to hear and manipulate individual phonemes. Phonemic awareness is the realization that within a word are individual sounds or phonemes."
            },
            {
                title: "什么是读书意识",
                title_eng: "What is print awareness",
                chn: "在你的孩子可以开始用英语朗读单词和句子之前，需要培养孩子的读书意识。 读书意识是指孩子对印刷品的理解和使用。 读书意识与词汇意识有直接关系。 词汇意识是将词语区分为读和写的能力（就是即会读，又能根据读音把单词写出来的能力）。 在幼儿园之前，大多数孩子应该拥有这个技能。 读书意识是发展读写能力的第一步，最好在学前班完成。",
                eng: "Before your child can start to read out words and sentences in English, the child needs to develop print awareness. Print awareness refers to a child’s understanding and use of print.  Print awareness has a direct relationship to word awareness. Word awareness is the ability to recognize words as distinct parts of oral and written communication. Before  kindergarten, most children should possess this skill. Print awareness is the first step in developing literacy and is best done at the preschool level."
            },
            {
                title: "怎样提高孩子的阅读意识",
                title_eng: "How can I develop my child's print awareness",
                chn: "以下是在学龄前儿童中发展阅读意识的一些技巧：<br><ul>" +
                "<li>带上一本儿童英语书。 将书的正面向下翻转，并要求孩子将其改正到自然阅读位置；</li>" +
                "<li>拿一本儿童英语书，让孩子向你展示正面；</li>" +
                "<li>请孩子指出本书的标题；</li>" +
                "<li>教字母A到Z的发音。这对于字母音素的一致性来说非常重要；</li>" +
                "<li>教孩子英文字母有大小写字母之分，如：A和a；</li>" +
                "<li>显示一个单词并询问孩子该单词中的哪些字母。 例如dog这个词有字母d，o，g；</li>" +
                "<li>在孩子的书中指出一个句子，让孩子看到单词之间用空格隔开；</li>" +
                "<li>告诉孩子哪里是书中开始进行阅读的位置；</li>" +
                "<li>向孩子指出句子的第一个词和最后一个词；</li>" +
                "<li>告诉孩子从左到右，从上到下的阅读习惯；</li>" +
                "<li>让孩子理解一本书有许多页，而且每个页都有编号；</li>" +
                "<li>拿出两本书，一本较少页，另一本更多页，并要求孩子指向更多页的书，反之亦然；</li>" +
                "<li>给孩子看一本儿童书，并指出书中可以有图片和文字；</li>" +
                "<li>向孩子指出句子的第一个单词，并要求他/她指出最后一个单词。</li>" +
                "</ul>" +
                "当你的孩子能够完成上面所有内容时，就具备了良好的阅读意识。",
                eng: "Here are a few techniques for developing print awareness in preschoolers：<br><ul>" +
                "<li>Take a childrens’ English book. Turn the book front side down and ask the child to correct it to the natural reading position.</li>" +
                "<li>Take a children’s English book and ask the child to show you the front.</li>" +
                "<li>Ask the child to point to the title of the book.</li>" +
                "<li>Teach the names of letters A to Z. It is very important for teaching letter sound correspondence.</li>" +
                "<li>Teach the child that letters in English have capital like A and small letters like a.</li>" +
                "<li>Show a word and ask the child which letters are in the word. For example the word dog has the letters d, o, g.</li>" +
                "<li>Show a sentence in the kids’ book and make a child see that words are separated by spaces.</li>" +
                "<li>Show the child where to start reading in a book.</li>" +
                "<li>Show the child the first word and last word of a sentence.</li>" +
                "<li>Point out to the child that we read from left to right and top to bottom of a page.</li>" +
                "<li>Show the child that books have pages and pages can be numbered.</li>" +
                "<li>Show two books, one with fewer pages, another with more pages and ask the child to point to books with more pages and vice versa.</li>" +
                "<li>Show the child a children’s book and point out that books can have pictures and texts.</li>" +
                "<li>Show the child the first word of a sentence and ask him or her to show you the last word.</li>" +
                "</ul>" +
                "When your child or children can do all of the above, they would have achieved good print awareness."
            },
            {
                title: "音素和字形有什么区别",
                title_eng: "What is the difference between a phoneme and a grapheme",
                chn: "我们之前说过，如果不同的发音代表不同的含义，那么音素是发音最小的单位。如果一个音素是可以区分含义的最小声音单位，那么字形是可以区分含义的书写的最小单位。字形可以是字母或符号。字母a是一个字形的例子。声音（音素）字素a可以发音为/ a /，如：apple。请注意，英语中有26个字母，但有44个音素。例如c可以发出两个声音，如：cat与city。另外，c可以与h结合，形成/ ch /，如：chair。这样想一想。有26个字母。其中字母'y'使4种不同的声音。不相信？看看这些单词吧：yak，gym，baby, cry。更糟糕的是，字母'y'可以发出辅音和元音。这意味着，在教音素时，字母表的字母不可靠，但它们可以成为学习字形和音素的良好开端。这就是为什么音素超出字母表字母的原因。",
                eng: "We said earlier that a phoneme is the smallest unit if sound that can differentiate meaning. If a phoneme is the smallest unit of sound that can differentiate meaning, then a grapheme is the smallest unit of written language that can differentiate meaning. A grapheme could be a letter or a symbol. The letter a is an example of a grapheme. The sound(phoneme) the grapheme a makes can be /a/ as in apple. Please note that the problem with English is that we have 26 letters of the alphabet, but over 44 phonemes. For example c can make two sounds. We have c as in cat and c as in city. Also, c can combine with h to make a different sound /ch/ as in chair. Think about it this way. There are 26 letters of the alphabet (which are 26 graphemes). One of these letters is 'y'. The letter 'y' makes 4 different sounds. Don't believe me? Well look at these words: yak, gym, baby, cry. To make matters worse, the letter 'y' can make consonant and vowel sounds. This means, the letters of the alphabet are unreliable for teaching phonemes, but they can be a good start for teaching key graphemes and phonemes. That is why phonics goes way beyond letters of the alphabet. "
            },
            {
                title: "英语中是否有不同类型的音素",
                title_eng: "Are there different types of phonemes in English",
                chn: "声音通常分为两组（一些人分成三组），元音，辅音和双元音。",
                eng: "Sounds are commonly broken up into two groups, some would say three - Vowels, Consonants and Diphthongs."
            },
            {
                title: "什么是元音",
                title_eng: "What are vowel sounds",
                chn: "元音是没有阻止肺部空气流动的声音。 最常见的元音是由字母a，e，i，o，u组成的。 这些字母可以分为短元音和长元音。 尝试说出以下词语：apple, egg, igloo, octopus, up。 你有没有注意到，当你说出a，e，i，o，u这些短元音时，你口中的空气不会停止， 这就是元音所做的。",
                eng: "Vowels are sounds that are said without stopping the flow of air from your lungs. The most commonly known vowel sounds are made by the letters  a, e, i, o, u. These letters can represent short and long vowels. Try to say the following words: apple, egg, igloo, octopus, up. Did you notice that when you say the short vowel sounds of a, e, i, o, u, the air in your mouth isn't stopped? That's what vowels do. "
            },
            {
                title: "什么是辅音",
                title_eng: "What are consonant sounds",
                chn: "辅音，是通过部分或完全关闭来自肺部的空气而形成的声音。 辅音除开元音a，e，i，o，u以外的字母，如：b，c，d，f，g，h等等。 英语中有25个辅音（音素）。",
                eng: "Consonants, are sounds that are made by partial or complete closure of  air coming from your lungs. Consonants are most commonly represented by all other letters that  are NOT a, e, i, o, u. This means b, c, d, f, g, h and the rest. There are 25 consonant sounds in English."
            },
            {
                title: "让人困惑的元音与辅音",
                title_eng: "consonant and vowel is confusing me",
                chn: "在你困惑之前，让我们简化一下：<br>有26个字母的字母。 可以通过26个字母来发出44种声音。在这些声音中，19个是元音，而25个是辅音。 元音最常用符号a，e，i，o，u表示。 辅音最常用符号b，c，d，f，g，h，j，k，l，m，n，p，q，r，s，t，v，w，x，y，z表示。 字母'y'既可以发辅音也可以发元音。 通过拼读法来组合这26个字母，我们可以学习44个声音（音素）。 例如，我们可以把ch组合在一起，发出chair的音。 结合2个字母形成一种音素称作连字音（两字母发一音）。 有辅音连字音和元音连字音。",
                eng: "Before you get confused, let's simplify things:<br>There are 26 letters of the alphabet. The 26 letters can be manipulated to make 44 sounds. There are 44 sounds in the English language. Of these sounds, 19 are vowel sounds, while 25 are consonant sounds. The vowels are most commonly represented by the symbols a, e, i, o, u. The consonants are most often represented by symbols b, c, d, f, g, h, j, k, l, m, n, p, q, r, s, t, v, w, x, y & z. The letter 'y' can make a consonant and vowel sound. By playing around with these 26 letters, through phonics, we can learn the 44 sounds (phonemes). For example, we can put ch together to make a new sound as in the word chair. This art of combining 2 letters to form one sound is called a digraph. There are consonant and vowel digraphs. "
            },
            {
                title: "什么是连字发音",
                title_eng: "Did you say digraphs",
                chn: "是的，你已经知道了。 连字音是指一对字母组合在一起形成一个声音。 例如，s + h结合起来，使我们在【fish】这个词的末尾听到的声音。 常见的辅音连字音包括：【chair】中的ch，【sheep】里的sh，【think】中的th，【duck】里的ch。 常见的元音连字音包括：oa，如【goat】，ee，如【feet】，ai，如【train】等。",
                eng: "Yes, I did and you already know it. A digraph is when a pair of letters come together to make one sound. For example, s + h combine to make the sound we hear at the end of fish. Common consonant digraphs include: ch as in chair, sh as in sheep, th as in think, ck as in duck. Common vowel digraphs include: oa as in goat, ee as in feet, ai as in train and more."
            },
            {
                title: "学习前还应该知道的",
                title_eng: "",
                chn: "到此，你已经掌握了《自然拼读法》的基本知识，在和孩子一起学习之前，你还应该知道：<br><ul>" +
                "<li>孩子有很强的模仿和学习能力，不要你认为知识点很难就认为孩子学不会，要相信孩子总能创造奇迹；</li>" +
                "<li>同时，要对孩子的学习过程有耐心，要知道一口吃不成胖子，学习是一个长期坚持的过程；</li>" +
                "<li>你可以和孩子一起学习，和孩子比赛；也可以让孩子学会后来教你，要知道当老师比当学生能学到更多知识；</li>" +
                "<li>语言学习很重要，但要明白语言只是交流的工具。所以要掌握好一门语言，更重要的是要与人交流；</li>" +
                "<li>学习语言需要氛围，把本站分享出去，让身边的孩子都参与进来，共同营造出英语学习的良好环境。</li>" +
                "<li>某些课后视频只是一些儿童英语歌曲，让孩子多听，可以提高孩子对英语的敏感程度。</li>" +
                "<li>在课程中你看到的英语字母和单词，基本都是可以单击发音的，在孩子不清楚发音时可以单击听声音。</li>" +
                "</ul>",
                eng: ""
            }
        ];
        $(function () {
            init_enlighten_page();
        });
    </script>
</head>
<body>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">英语启蒙</li>
        <li class="breadcrumb-item active" aria-current="page">预备</li>
        <li class="breadcrumb-item"><a href="enlighten_study_1.php">开始</a></li>
    </ol>
</nav>
<div class="container-fluid mt-2 max_page_width">
    <div class="row">
        <div class="col-12 mb-3">
            <div id="page_content">
                <div id="accordion">
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
