<link rel="stylesheet" href="https://cdn.datatables.net/3.0.2/css/dataTables.dataTables.min.css" />
<script src="https://cdn.datatables.net/3.0.2/js/dataTables.min.js"></script>
<style>
    table img { max-width: 100px; }
    .table-responsive { max-width: 100%; overflow-x: scroll; }
</style>
<h2>แนะนำตัวละคร</h2>
<?php
$characters = [
    [
        'character-chen-kevin.webp',
        'Chen, Kevin (Kev, Chen Guowei) / เควิน (เคฟ) เฉิน / 陳國偉',
        'ไอ้หมาน้อย (Little Pup) / โคคุอิ (こくい, Kokui)',
        '英徳 / SLIS / SLH / SICT / DCC-SU',
        'M',
        'TW',
        'TH-TW',
        '2005-11-15',
        'li-kev li-thatchai'
    ],
    [
        'character-tan-chun.webp',
        'Tan, Chun (Chen Junwei) / ชุน ตัน / 陳俊偉',
        'Aussie Boy / ตันจุ้นเหว่ย',
        '英徳 / Clifton / SBS-SU',
        'M',
        'AU',
        'TH-SG',
        '2005-10-05',
        'li-kev'
    ],
    [
        'character-tangcharoenkit-kan.webp',
        'Tângchàrōenkìt, Kan / กันต์ ตั้งเจริญกิจ',
        '',
        'SLIS / SLH / DCC-SU',
        'M',
        'TH',
        'TH',
        '2006',
        'li-kan'
    ],
    [
        'character-zhang-weixiang.webp',
        'Zhang Weixiang / จางเหว่ยเฉียง / 張偉翔',
        '',
        '英徳',
        'M',
        'TW',
        'TW',
        '2005'
    ],
    [
        'character-muller-jane.webp',
        'Müller, Jane Charlotte / เจน ชาร์ลอท มึลเลอร์',
        'JC (เจซี)',
        'SLIS / SLH / OAIS / CCC-SU',
        'F',
        'TH',
        'DE-TH',
        '2006-02-17',
        'li-kev li-jane'
    ],
    [
        'character-phunkit-anachai.webp',
        'Phūnkìt, Ànanchai (Ôen) / อนันต์ชัย (เอิ้น) พูลกิจ',
        '',
        'SLH / SICT',
        'M',
        'TH',
        'TH',
        '2005',
        'li-tam'
    ],
    [
        'character-sawangwit-thanat.webp',
        'Sàwàngwít, Thánát (Tâm) / ธนัท (ตั้ม) สว่างวิทย์',
        '',
        'SLH / SICT',
        'M',
        'TH',
        'TH',
        '2005',
        'li-tam'
    ],
    [
        'character-chanawong-thatchai.webp',
        'Chánáwong, Thátchai / ธัชชัย ชนะวงศ์',
        '',
        'Khorat / Bangkok / SICT',
        'M',
        'TH',
        'TH',
        '2005',
        'li-thatchai li-jack'
    ],
    [
        'character-sakdaphithak-kittiphum.webp',
        'Sàkdāphíthák, Kìttìphūm (Jack) / กิตติภูมิ (แจ็ค) ศักดาพิทักษ์',
        '',
        'Khorat / Bangkok / SICT',
        'M',
        'TH',
        'TH',
        '2005',
        'li-jack'
    ],
    [
        'character-gonzalez-jose.webp',
        'González, José / โฮเซ่ กอนซาเลส',
        '',
        'SBS-SU',
        'M',
        'US',
        'US-MX',
        '2005'
    ],
    [
        'character-ong-ruby.webp',
        'Ong, Ruby / รูบี้ ออง',
        '',
        'DCC-SU',
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
        'OAIS / CCC-SU',
        'M',
        'KR',
        'KR',
        '2005',
        'li-jane'
    ],
    [
        'character-intharasen-wasan.webp',
        'Inthárásěn, Wásǎn (Sǎn) / วสันต์ (สัน) อินทรเสน',
        '',
        'SLH / Japan',
        'M',
        'TH',
        'TH',
        '2006',
        'li-kan'
    ],
    [
        'character-loetwiriya-thiraphon.webp',
        'Lôetwíríyá, Thīráphon (Thī) / ธีรพล (ธีร์) เลิศวิริยะ',
        '',
        'SLH / Japan',
        'M',
        'TH',
        'TH',
        '2006',
        'li-thi'
    ],
    [
        'character-jantharawirot-kasidit.webp',
        'Jantháráwírôt, Kàsìdìt (Kâo) / กษิดิศ (เก้า) จันทรวิโรจน์',
        '',
        'SLH / Japan',
        'M',
        'TH',
        'TH',
        '2006',
        'li-thi'
    ]
];
?>
<div class="table-responsive">
<table class="table border-collapse table-auto datatables w-full" id="characters">
    <thead>
    <tr>
        <th>Image</th>
        <th>Names</th>
        <th>Aliases</th>
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
        <td data-sort="<?= $i ?>"><img alt="<?= @$character[1] ?>" src="illustrations/<?= @$character[0] ?>" /></td>
        <td data-search="<?= @$character[8] ?>"><?= str_replace('/', '<br/>', $character[1]??'') ?></td>
        <td><?= str_replace('/', '<br/>', $character[2]??'') ?></td>
        <td><?= str_replace('/', '<br/>', $character[3]??'') ?></td>
        <td><?= @$character[4] ?></td>
        <td><?= @$character[5] ?></td>
        <td><?= @$character[6] ?></td>
        <td><?= @$character[7] ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let tbl = new DataTable('#characters');
    });
</script>