<?php
return [
	'mode'                 => '',
	'format'               => 'A4',
	'default_font_size'    => '12',
	'default_font'         => 'kanit',
	'margin_left'          => 0,
	'margin_right'         => 0,
	'margin_top'           => 0,
	'margin_bottom'        => 0,
	'margin_header'        => 0,
	'margin_footer'        => 0,
	'orientation'          => 'P',
	'title'                => 'Laravel mPDF',
	'author'               => '',
	'watermark'            => '',
	'show_watermark'       => false,
	'use_kw' => true,
	'watermark_font'       => 'kanit',
	'keep_table_proportions'       => true,
	'shrink_tables_to_fit'       => 1,
	'display_mode'         => 'fullpage',
	'watermark_text_alpha' => 0.1,
	'custom_font_dir'      => base_path('public/assets/fonts/kanit/'),
	'custom_font_data' 	   =>  [
                'kanit' => [
                    'R'  => 'Kanit-Light.ttf',    
                    'B'  => 'Kanit-Bold.ttf',       
                    'I'  => 'Kanit-Italic.ttf',    
                    'BI' => 'Kanit-BoldItalic.ttf' 
                ]
            ],
	'auto_language_detection'  => false,
	'temp_dir'               => base_path('public/storage/'),
	'pdfa' 			=> false,
	'pdfaauto' 		=> false,
	'justifyB4br' 	=> false,
];