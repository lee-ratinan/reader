<link rel="stylesheet" href="https://cdn.datatables.net/3.0.2/css/dataTables.dataTables.min.css" />
<script src="https://cdn.datatables.net/3.0.2/js/dataTables.min.js"></script>
<style>
    table img { max-width: 100px; }
</style>
<?php
$locations = [
    [
        'St. Lucius International School',
        'โรงเรียนนานาชาติเซนต์ลูเซียส',
        'กรุงเทพ ประเทศไทย',
        'school',
        '',
        'fictional'
    ],
    [
        'St. Lucius High School (SLH)',
        'โรงเรียนมัธยมเซนต์ลูเซียส',
        'กรุงเทพ ประเทศไทย',
        'school',
        'ชื่อเล่น Sukhumvit Lawless High เป็นโรงเรียนมัธยมหรูที่มีนักเรียนรวยๆ จำนวนมาก',
        'fictional'
    ],
    [
        'Surasak International College of Technology(SICT)',
        'มหาวิทยาลัยเทคโนโลยีนานาชาติสุรศักดิ์',
        'กรุงเทพ ประเทศไทย',
        'university',
        '',
        'fictional'
    ],
    [
        'Yingde International School [Yīngdé]',
        '英徳國際學校',
        '台灣台北',
        'school',
        '',
        'fictional'
    ],
    [
        'Clifton High School',
        '',
        'Clifton, Sydney, NSW',
        'school',
        '',
        'fictional'
    ],
    [
        'Straits University',
        'มหาวิทยาลัยสเตรทส์',
        'Singapore',
        'university',
        '',
        'fictional'
    ]
];
?>
<h2>แนะนำสถานที่</h2>
<div class="w-full overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full min-w-[600px] text-left text-sm" id="locations">
        <thead>
        <tr>
            <th>Location Name</th>
            <th>(in native language)</th>
            <th>City</th>
            <th>Type</th>
            <th>Fictional?</th>
            <th>Some Explanation</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($locations as $row) : ?>
        <tr>
            <td><?= @$row[0] ?></td>
            <td><?= @$row[1] ?></td>
            <td><?= @$row[2] ?></td>
            <td><?= @$row[3] ?></td>
            <td><?= @$row[5] ?></td>
            <td><?= @$row[4] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    new DataTable('#locations');
</script>