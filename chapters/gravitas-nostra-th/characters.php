<link rel="stylesheet" href="https://cdn.datatables.net/3.0.2/css/dataTables.dataTables.min.css" />
<script src="https://cdn.datatables.net/3.0.2/js/dataTables.min.js"></script>
<style>
    table img { max-width: 100px; }
</style>
<h2>แนะนำตัวละคร</h2>
<?php
$characters = [
    [
        'character-chen-kevin.webp',
        'Chen, Kevin (Kev, Chen Guo Wei) / เควิน (เคฟ) เฉิน กั๋วเหว่ย / 陳國偉',
        'ไอ้หมาน้อย (Little Pup) / โคคุอิ (こくい, Kokui)',
        '英徳 / SLIS / SLH’23 / SICT’27 / DCC-SU’28',
        'M',
        'TW',
        'TH-TW',
        '2005-11-15',
        'li-kev li-thatchai main-character',
        'Chén Guó Wěi'
    ],
    [
        'character-tan-chun.webp',
        'Tan, Chun / ชุน ตัน / ตันจุ้นเหว่ย / 陳俊偉',
        'ออสซี่บอย (Aussie Boy)',
        '英徳 / Clifton’24 / SBS-SU’28',
        'M',
        'AU',
        'TH-SG',
        '2005-10-05',
        'li-kev li-chun main-character',
        'Chén/Tan Jùn Wěi'
    ],
    [
        'character-tangcharoenkit-kan.webp',
        'Tangjaroenkit, Kan / กันต์ ตั้งเจริญกิจ',
        '',
        'SLIS / SLH’24 / DCC-SU’28',
        'M',
        'TH',
        'TH',
        '2006',
        'li-kan main-character',
        'Tângjàrōenkìt, Kan'
    ],
    [
        'character-zhang-weixiang.webp',
        'Zhang Weixiang / จางเหว่ยเฉียง / 張偉翔',
        '',
        '英徳',
        'M',
        'TW',
        'TW',
        '2005',
        '',
        'Zhāng Wěi Xiáng'
    ],
    [
        'character-muller-jane.webp',
        'Müller, Jane Charlotte / เจน ชาร์ลอท มึลเลอร์',
        'JC (เจซี)',
        'SLIS / SLH’23 / OAIS’23 / CCC-SU’27',
        'F',
        'TH',
        'DE-TH',
        '2006-02-17',
        'li-kev li-jane'
    ],
    [
        'character-phunkit-anachai.webp',
        'Phoonkit, Ananchai (Ern) / อนันต์ชัย (เอิ้น) พูลกิจ',
        '',
        'SLH’23 / SICT’27',
        'M',
        'TH',
        'TH',
        '2005',
        'li-tam supporting',
        'Phūnkìt, Ànanchai (Ôen)'
    ],
    [
        'character-sawangwit-thanat.webp',
        'Sawangwit, Thanat (Tâm) / ธนัท (ตั้ม) สว่างวิทย์',
        '',
        'SLH’23 / SICT’27',
        'M',
        'TH',
        'TH',
        '2005',
        'li-tam supporting',
        'Sàwàngwít, Thánát (Tâm)'
    ],
    [
        'character-chanawong-thatchai.webp',
        'Chanawong, Thatchai / ธัชชัย ชนะวงศ์',
        'ตัวเล็ก (Shorty)',
        'Khorat / Bangkok / SICT’27 - SICT’28',
        'M',
        'TH',
        'TH',
        '2005',
        'li-thatchai li-jack',
        'Chánáwong, Thátchai'
    ],
    [
        'character-sakdaphithak-kittiphum.webp',
        'Sakdapitak, Kittipoom (Jack) / กิตติภูมิ (แจ็ค) ศักดาพิทักษ์',
        '',
        'Khorat / Bangkok / SICT’27',
        'M',
        'TH',
        'TH',
        '2005',
        'li-jack',
        'Sàkdāphíthák, Kìttìphūm'
    ],
    [
        'character-gonzalez-jose.webp',
        'González, José / โฮเซ่ กอนซาเลส',
        '',
        'SBS-SU’28',
        'M',
        'US',
        'US-MX',
        '2005'
    ],
    [
        'character-ong-ruby.webp',
        'Ong, Ruby / รูบี้ ออง',
        '',
        'DCC-SU’28',
        'F',
        'SG',
        'SG',
        '2006',
        'li-kan'
    ],
    [
        'character-park-seojun.webp',
        'Park Seo-jun / พัก ซอจุน / 박서준',
        '',
        'OAIS’23 / CCC-SU’27',
        'M',
        'KR',
        'KR',
        '2005',
        'li-jane'
    ],
    [
        'character-intharasen-wasan.webp',
        'Intharasane, Wasan (San) / วสันต์ (สัน) อินทรเสน',
        '',
        'SLH’24 / 東京大学’28',
        'M',
        'TH',
        'TH',
        '2006',
        'li-kan main-character',
        'Inthárásěn, Wásǎn (Sǎn)'
    ],
    [
        'character-loetwiriya-thiraphon.webp',
        'Lertwiriya, Theerapon (Thee) / ธีรพล (ธีร์) เลิศวิริยะ',
        '',
        'SLH’24 / SICT’28',
        'M',
        'TH',
        'TH',
        '2006',
        'li-thi supporting',
        'Lôetwíríyá, Thīráphon (Thī)'
    ],
    [
        'character-jantharawirot-kasidit.webp',
        'Chantarawirote, Kasidit (Kao) / กษิดิศ (เก้า) จันทรวิโรจน์',
        '',
        'SLH’24 / SICT’28',
        'M',
        'TH',
        'TH',
        '2006',
        'li-thi supporting',
        'Jantháráwírôt, Kàsìdìt (Kâo)'
    ],
    [
        '',
        'Smith, Patrick / แพททริค สมิธ',
        '',
        'Clifton’24',
        'M',
        'AU',
        'AU',
        '2006'
    ],
    [
        '',
        'Baker, Cindy / ซินดี้ เบเกอร์',
        '',
        'Clifton’24',
        'F',
        'AU',
        'ZH',
        '2006',
        'li-chun'
    ],
    [
        '',
        'Higgs, Mrs / ฮิกส์',
        '',
        'Clifton',
        'F',
        'AU',
        'AU',
        ''
    ],
    [
        '',
        'Smith, Mr / สมิธ',
        '',
        'Clifton',
        'M',
        'AU',
        'AU',
        ''
    ],
    [
        '',
        'Smith, Mrs / สมิธ',
        '',
        'Clifton',
        'F',
        'AU',
        'AU',
        ''
    ],
    [
        '',
        'Nattawut (Wut) / ณัฐวุฒิ (วุฒิ)',
        '',
        'SLH’23',
        'M',
        'TH',
        'TH',
        '2005',
        '',
        'Nátthàwút (Wút)'
    ],
    [
        '',
        'Jetsada (Jate) / เจษฎา (เจษ)',
        '',
        'SLH’23',
        'M',
        'TH',
        'TH',
        '2005',
        '',
        'Jètsàdā (Jèt)'
    ],
    [
        '',
        'Tee / ตี๋',
        '',
        'SLH’23',
        'M',
        'TH',
        'TH',
        '2005',
        '',
        'Tǐ'
    ],
    [
        '',
        'Film / ฟิล์ม',
        '',
        'SLH’23',
        'M',
        'TH',
        'TH',
        '2005',
        '',
        'Fīm'
    ],
    [
        '',
        'Nune / นุ่น',
        '',
        'SLH’23',
        'F',
        'TH',
        'TH',
        '2005',
        '',
        'Nûn'
    ],
    [
        '',
        'Ladda / ลัดดา',
        '',
        'SLH’24',
        'F',
        'TH',
        'TH',
        '2006',
        '',
        'Látdā'
    ],
    [
        '',
        'Boyle, Bradley / บอยล์ แบรดลีย์',
        '',
        'SLH',
        'M',
        'GB',
        'GB',
        ''
    ],
    [
        '',
        'Peem / ภีม',
        '',
        'SICT’27',
        'M',
        'TH',
        'TH',
        '',
        '',
        'Phīm'
    ],
    [
        '',
        'Wales, Prof James / เจมส์ เวลส์',
        '',
        'SICT',
        'M',
        'US',
        'US',
        ''
    ],
    [
        '',
        'Flores, Juan / ฮวน ฟลอเรส',
        '',
        'DCC-SU’28',
        'M',
        'PH',
        'PH',
        '2006'
    ],
    [
        '',
        'Lee, Francis / แฟรนซิส ลี',
        '',
        'DCC-SU’28',
        'M',
        'SG',
        'SG',
        '2006'
    ],
    [
        '',
        'Tanaka Ryōta / ทะนะกะ เรียวตะ / 田中涼太',
        '',
        'DCC-SU’28',
        'M',
        'JP',
        'JP',
        '2006'
    ],
    [
        '',
        'Linardi, Ady / อาดี้ ลีนาร์ดี้',
        '',
        'DCC-SU’28',
        'M',
        'ID',
        'ID',
        '2006'
    ],
    [
        '',
        'Ang, Philip / ฟิลิป อัง',
        '',
        'DCC-SU’28',
        'M',
        'MY',
        'MY',
        '2006'
    ],
    [
        '',
        'Hartono, Nadia / นาเดีย ฮาร์โตโน',
        '',
        'DCC-SU’28',
        'F',
        'ID',
        'ID',
        '2006'
    ],
    [
        '',
        'Ma, Jolie / โจลี่ หม่า',
        '',
        'DCC-SU’28',
        'F',
        'SG',
        'SG-ZH',
        '2006'
    ],
    [
        '',
        'Ng, Jay / เจย์ อึ้ง',
        '',
        'DCC-SU’28',
        'M',
        'SG',
        'ZH',
        '2006'
    ],
    [
        '',
        'Sim, Jeremiah (Jerry) / เจอระไมยาห์ (เจอร์รี่) ซิม',
        '',
        'DCC-SU’28',
        'M',
        'SG',
        'ZH',
        '2006'
    ],
    [
        '',
        'Wang, Prof / ศาสตราจารย์หวัง / 王老師',
        '',
        'DCC-SU',
        'F',
        'SG',
        'SG',
        ''
    ],
    [
        '',
        'Goh, Prof / ศาสตราจารย์โก๊ะ / 吳老師',
        '',
        'DCC-SU',
        'M',
        'SG',
        'SG',
        ''
    ],
    [
        '',
        'Teng, Dean / ดีน เทง',
        '',
        'SBS-SU’28',
        'M',
        'SG',
        'SG',
        '2006'
    ],
    [
        '',
        'Lim, Raymond / เรย์เมินด์ ลิม',
        '',
        'SBS-SU’28',
        'M',
        'SG',
        'SG',
        '2006'
    ],
    [
        '',
        'Wilson, Emma / เอ็มม่า วิลซัน',
        '',
        'SBS-SU’28',
        'F',
        'SG',
        'SG',
        '2006'
    ],
    [
        '',
        'Paul / พอล',
        '',
        'SBS-SU’28',
        'M',
        'SG',
        'SG',
        '2006'
    ],
    [
        '',
        'Jiajia / เจียเจีย',
        '',
        'SBS-SU’28',
        'F',
        'SG',
        'SG',
        '2006'
    ],
    [
        '',
        'Riña, Matthew / แมททิว ริญ่า',
        '',
        'CCC-SU’27',
        'M',
        'PH',
        'PH',
        '2005'
    ],
    [
        '',
        'Xi Luyan / สีลู่เยียน / 习露嫣',
        '',
        'SU’28',
        'F',
        'ZH',
        'ZH',
        '2006',
        '',
        'Xí Lùyān'
    ],
    [
        '',
        'Nakagawa Ryu / นาคากาวะ ริว / 中川龍',
        '',
        'OAIS’23',
        'M',
        'JP',
        'JP',
        '2005'
    ],
    [
        '',
        'Nishida Miyuki / นิชิดะ มิยูกิ / 西田美雪',
        '',
        'OAIS’23',
        'F',
        'JP',
        'JP',
        '2005'
    ],
    [
        '',
        'Aryan, Randy (Di) / แรนดี้ (ดี้) อารยัน',
        '',
        'OAIS’23',
        'M',
        'ID',
        'ID',
        '2005'
    ],
    [
        '',
        'Priya / ปรียา',
        '',
        'OAIS’23',
        'F',
        'IN',
        'IN',
        '2005'
    ],
    [
        '',
        'Tony Estadilla / โทนี่ เอสตาดีญ่า',
        '',
        '',
        'M',
        'US',
        'US-MX',
        '2006'
    ],
    [
        '',
        'Miller, Dr / ดร. มิลเลอร์',
        '',
        '',
        'M',
        'US',
        'US',
        '',
        'psychologist'
    ],
    [
        '',
        'Ke, Dr / ดร. เคอ / 柯心理師',
        '',
        '',
        'M',
        'TW',
        'TW',
        '',
        'psychologist'
    ],
    ['', 'Tangjaroenkit, Tawan / ตะวัน ตั้งเจริญกิจ', '', '', 'M', 'TH', 'TH', '', 'family', 'Tângjàrōenkìt, Tàwan'],
    ['', 'Masha Chen / มาช่า เฉิน', '', '', 'F', 'TW', 'TW-GB', '', 'family', 'Masha Chén'],
    ['', 'Kansombat, Sakda / ศักดา กาญจน์สมบัติ', '', '', 'M', 'TH', 'TH', '', 'family', 'Kānsǒmbàt, Sàkdā'],
    ['', 'Lily Tan / ลิลี่ ตัน', '', '', 'F', 'SG', 'SG', '', 'family'],
    ['', 'Tangjaroenkit, Akkanee / อัคนี ตั้งเจริญกิจ', '', '', 'M', 'TH', 'TH', '', 'family', 'Tângchàrōenkìt, Àkkhánī'],
    ['', 'Tangjaroenkit, Yada / ญาดา ตั้งเจริญกิจ', '', '', 'F', 'TH', 'TH', '', 'family', 'Tângchàrōenkìt, Yādā'],
    ['', 'Zhang, Mrs (Weixiang’s Mother) / จาง', '', '', 'F', 'TW', 'TW', '', 'family'],
    ['', 'Clarke, Jasmine (née Tan) / แจสมิน คลาร์ก (ตัน)', '', '', 'F', 'AU', 'SG', '', 'family'],
    ['', 'Clarke, Max / แม็กซ์ คลาร์ก', '', '', 'M', 'AU', 'AU', '', 'family'],
    ['', 'Clarke, Joanna / โจแอนนา คลาร์ก', '', '', 'F', 'AU', 'AU-SG', '', 'family'],
    ['', 'Tan, Mrs (grandmother) / ตัน', '', '', 'F', 'SG', 'SG', '', 'family'],
    ['', 'Tan, Ben / เบ็น ตัน', '', '', 'M', 'SG', 'SG', '', 'family'],
    ['', 'Chanawong, Mr (big military officer) / ชนะวงศ์', '', '', 'M', 'TH', 'TH', '', 'family', 'Chánáwong'],
    ['', 'Chanawong, Mrs (passed away) / ชนะวงศ์', '', '', 'F', 'TH', 'TH', '', 'family', 'Chánáwong'],
    ['', 'Sakdapitak, Mr (passed away) / ศักดาพิทักษ์', '', '', 'M', 'TH', 'TH', '', 'family', 'Sàkdāphíthák'],
    ['', 'Sakdapitak, Ms / ศักดาพิทักษ์', '', '', 'F', 'TH', 'TH', '', 'family', 'Sàkdāphíthák'],
    ['', 'Teng, Mr / เทง', '', '', 'M', 'SG', 'SG', '', 'family'],
    ['', 'Teng, Mrs / เทง', '', '', 'F', 'SG', 'SG', '', 'family'],
    ['', 'Teng, Debra / เด็บบรา เทง', '', '', 'F', 'SG', 'SG', '', 'family'],
    ['', 'Teng, Mrs (grandmother) / เทง', '', '', 'F', 'SG', 'SG', '', 'family'],
];
function country_to_name(string $codes = ''): string
{
    if (empty($codes)) {
        return '';
    }
    $matching = [
        'AU' => 'Australia',
        'DE' => 'German',
        'GB' => 'British',
        'ID' => 'Indonesian',
        'IN' => 'Indian',
        'JP' => 'Japanese',
        'KR' => 'South Korean',
        'MX' => 'Mexican',
        'MY' => 'Malaysian',
        'PH' => 'Filipino',
        'SG' => 'Singaporean',
        'TH' => 'Thai',
        'TW' => 'Taiwanese',
        'US' => 'American',
        'ZH' => 'Evil Chinese',
    ];
    $array = explode('-', $codes);
    $names = [];
    foreach ($array as $cd) {
        $names[] = $matching[$cd] ?? '???';
    }
    return implode('<br/>', $names);
}
?>
<div class="w-full overflow-x-auto shadow-md sm:rounded-lg">
<table class="w-full min-w-[600px] text-left text-sm" id="characters">
    <thead>
    <tr>
        <th>Image</th>
        <th>Names</th>
        <th>Aliases</th>
        <th>Pronunciation</th>
        <th>Affiliations</th>
        <th>G.</th>
        <th>Nat.</th>
        <th>Eth.</th>
        <th>DOB</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($characters as $i => $character): ?>
    <tr>
        <td data-sort="<?= $i ?>"><?= (!empty($character[0]) ? '<img alt="'. @$character[1] .'" src="illustrations/' . @$character[0] . '" />' : '') ?></td>
        <td data-sort="<?= @$character[1] ?>" data-search="<?= @$character[8] . ' ' . $character[1] ?>">
            <small><code>[C<?= str_pad($i+1, 3, '0', STR_PAD_LEFT) ?>]</code></small><br/>
            <?= str_replace('/', '<br/>', $character[1]??'') ?>
        </td>
        <td><?= str_replace('/', '<br/>', $character[2]??'') ?></td>
        <td><?= @$character[9] ?></td>
        <td><?= str_replace('/', '<br/>', $character[3]??'') ?></td>
        <td><?= @$character[4] ?></td>
        <td><?= country_to_name(@$character[5]) ?></td>
        <td><?= country_to_name(@$character[6]) ?></td>
        <td><?= @$character[7] ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<script>
    new DataTable('#characters');
</script>
<div class="w-full">
    <?php /* foreach ($characters as $row) {
        if (!empty($row[1])) {
            echo '- Name: '. $row[1];
        }
        if (!empty($row[2])) {
            echo ', alias(es)/nickname(s): ' .  $row[2];
        }
        if (!empty($row[9])) {
            echo ' - pronounced: ' . $row[9];
        }
        echo '<br/>';
        if (!empty($row[4])) {
            echo 'Gender: ' .  $row[4];
        }
        if (!empty($row[5])) {
            echo ', nationality: ' .  str_replace('-', ', ', $row[5]);
        }
        if (!empty($row[6])) {
            echo ', ethnicity: ' .  str_replace('-', ', ', $row[6]);
        }
        if (!empty($row[7])) {
            echo ', birth: ' .  $row[7];
        }
        echo '<br/>';
    } */ ?>
</div>