<?php

// Create a simple test image
$image = imagecreatetruecolor(400, 300);
$bg = imagecolorallocate($image, 255, 255, 255);
$textcolor = imagecolorallocate($image, 0, 0, 0);
imagefill($image, 0, 0, $bg);
imagestring($image, 5, 150, 140, 'Test Image', $textcolor);

// Save the image
imagejpeg($image, __DIR__ . '/banjir_test.jpg');
imagedestroy($image);

// Create a simple PDF file (text file with PDF extension for testing)
file_put_contents(__DIR__ . '/dokumen_test.pdf', '%PDF-1.4
1 0 obj
<< /Type /Catalog
/Pages 2 0 R
>>
endobj
2 0 obj
<< /Type /Pages
/Kids [3 0 R]
/Count 1
>>
endobj
3 0 obj
<< /Type /Page
/Parent 2 0 R
/Resources << >>
/MediaBox [0 0 612 792]
/Contents 4 0 R
>>
endobj
4 0 obj
<< /Length 21 >>
stream
BT /F1 12 Tf (Test PDF) Tj ET
endstream
endobj
xref
0 5
0000000000 65535 f
0000000010 00000 n
0000000060 00000 n
0000000120 00000 n
0000000220 00000 n
trailer
<< /Size 5
/Root 1 0 R
>>
startxref
290
%%EOF');

echo "Test files created successfully!\n";
