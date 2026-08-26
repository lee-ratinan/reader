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
        'เควิน (เคฟ) เฉิน / Kevin (Kev) Chen / 陳國偉',
        'ไอ้หมาน้อย / Little Pup',
        '英徳國際學校 / โรงเรียนนานาชาติ เซนต์ ลูเซียส / โรงเรียนมัธยม เซนต์ ลูเซียส / Surasak International College of Technology / Deans College of Computing',
        'M',
        'TW',
        'TH-TW',
        '2005-11-15'
    ],
    [
        'character-tan-chun.webp',
        'ชุน ตัน / Chun Tan / 陳俊偉',
        'Aussie Boy',
        '英徳國際學校 / Clifton High School',
        'M',
        'AU',
        'TH-SG',
        '2005'
    ],
    [
        'character-tangcharoenkit-kan.webp',
        'กันต์ ตั้งเจริญกิจ / Kan Tângchàrōenkìt',
        '',
        'โรงเรียนมัธยม เซนต์ ลูเซียส'
    ],
    [
        'character-zhang-weixiang.webp',
    ],
    [
        'character-muller-jason.webp',
    ],
    [
        'character-phunkit-anachai.webp',
    ],
    [
        'character-sawantwit-thanat.webp',
    ],
    [
        'character-chanawong-thatchai.webp'
    ],
    [
        'character-sakdaphithak-kittiphum.webp'
    ],
    [
        'character-gonzalez-jose.webp'
    ],
    [
        'character-ong-ruby.webp'
    ],
    [
        'character-park-seojun.webp'
    ]
];
?>

<table class="border-collapse table-auto datatables w-full" id="characters">
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
    <?php foreach($characters as $character): ?>
    <tr>
        <td><img alt="<?= @$character[1] ?>" src="illustrations/<?= @$character[0] ?>" /></td>
        <td><?= str_replace('/', '<br/>', $character[1]??'') ?></td>
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let tbl = new DataTable('#characters');
    });
</script>