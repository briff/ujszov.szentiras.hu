<?php

use Illuminate\Database\Migrations\Migration;

class AddNewBooks extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = DB::table('konyvnevek');
        $table->truncate();
        foreach ($this->newBooks as $book) {
            $table->insert($book);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = DB::table('konyvnevek');
        $table->truncate();
        foreach ($this->oldBookList as $book) {
            $table->insert($book);
        }
    }

    private $oldBookList = [
        [
            "nev" => "Mt",
            "konyv_id" => 1,
            "tipus" => "default",
            "hossz" => 28
        ],
        [
            "nev" => "Mk",
            "konyv_id" => 2,
            "tipus" => "default",
            "hossz" => 16
        ],
        [
            "nev" => "Lk",
            "konyv_id" => 3,
            "tipus" => "default",
            "hossz" => 24
        ],
        [
            "nev" => "Jn",
            "konyv_id" => 4,
            "tipus" => "default",
            "hossz" => 21
        ],
        [
            "nev" => "Acs",
            "konyv_id" => 5,
            "tipus" => "default",
            "hossz" => 28
        ],
        [
            "nev" => "Róm",
            "konyv_id" => 6,
            "tipus" => "default",
            "hossz" => 16
        ],
        [
            "nev" => "1Kor",
            "konyv_id" => 7,
            "tipus" => "default",
            "hossz" => 16
        ],
        [
            "nev" => "2Kor",
            "konyv_id" => 8,
            "tipus" => "default",
            "hossz" => 13
        ],
        [
            "nev" => "Gal",
            "konyv_id" => 9,
            "tipus" => "default",
            "hossz" => 6
        ],
        [
            "nev" => "Ef",
            "konyv_id" => 10,
            "tipus" => "default",
            "hossz" => 6
        ],
        [
            "nev" => "Fil",
            "konyv_id" => 11,
            "tipus" => "default",
            "hossz" => 4
        ],
        [
            "nev" => "Kol",
            "konyv_id" => 12,
            "tipus" => "default",
            "hossz" => 4
        ],
        [
            "nev" => "1Tessz",
            "konyv_id" => 13,
            "tipus" => "default",
            "hossz" => 5
        ],
        [
            "nev" => "2Tessz",
            "konyv_id" => 14,
            "tipus" => "default",
            "hossz" => 3
        ],
        [
            "nev" => "1Tim",
            "konyv_id" => 15,
            "tipus" => "default",
            "hossz" => 6
        ],
        [
            "nev" => "2Tim",
            "konyv_id" => 16,
            "tipus" => "default",
            "hossz" => 4
        ],
        [
            "nev" => "Tit",
            "konyv_id" => 17,
            "tipus" => "default",
            "hossz" => 3
        ],
        [
            "nev" => "Filem",
            "konyv_id" => 18,
            "tipus" => "default",
            "hossz" => 1
        ],
        [
            "nev" => "Zsid",
            "konyv_id" => 19,
            "tipus" => "default",
            "hossz" => 13
        ],
        [
            "nev" => "Jak",
            "konyv_id" => 20,
            "tipus" => "default",
            "hossz" => 5
        ],
        [
            "nev" => "1Pt",
            "konyv_id" => 21,
            "tipus" => "default",
            "hossz" => 5
        ],
        [
            "nev" => "2Pt",
            "konyv_id" => 22,
            "tipus" => "default",
            "hossz" => 3
        ],
        [
            "nev" => "1Jn",
            "konyv_id" => 23,
            "tipus" => "default",
            "hossz" => 5
        ],
        [
            "nev" => "2Jn",
            "konyv_id" => 24,
            "tipus" => "default",
            "hossz" => 1
        ],
        [
            "nev" => "3Jn",
            "konyv_id" => 25,
            "tipus" => "default",
            "hossz" => 1
        ],
        [
            "nev" => "Júd",
            "konyv_id" => 26,
            "tipus" => "default",
            "hossz" => 1
        ],
        [
            "nev" => "Jel",
            "konyv_id" => 27,
            "tipus" => "default",
            "hossz" => 22
        ],
        [
            "nev" => "2Thes",
            "konyv_id" => 14,
            "tipus" => "szomutato",
            "hossz" => 3
        ],
        [
            "nev" => "1Thes",
            "konyv_id" => 13,
            "tipus" => "szomutato",
            "hossz" => 5
        ],
        [
            "nev" => "2Thessz",
            "konyv_id" => 14,
            "tipus" => "ujprotestans",
            "hossz" => 3
        ],
        [
            "nev" => "1Thessz",
            "konyv_id" => 13,
            "tipus" => "ujprotestans",
            "hossz" => 5
        ],
        [
            "nev" => "2Thess",
            "konyv_id" => 14,
            "tipus" => "karoli",
            "hossz" => 3
        ],
        [
            "nev" => "1Thess",
            "konyv_id" => 13,
            "tipus" => "karoli",
            "hossz" => 5
        ],
        [
            "nev" => "Eféz",
            "konyv_id" => 10,
            "tipus" => "karoli",
            "hossz" => 6
        ],
        [
            "nev" => "Ján",
            "konyv_id" => 4,
            "tipus" => "karoli",
            "hossz" => 21
        ],
        [
            "nev" => "Luk",
            "konyv_id" => 3,
            "tipus" => "karoli",
            "hossz" => 24
        ],
        [
            "nev" => "Márk",
            "konyv_id" => 2,
            "tipus" => "karoli",
            "hossz" => 16
        ],
        [
            "nev" => "Mát",
            "konyv_id" => 1,
            "tipus" => "karoli",
            "hossz" => 28
        ],
        [
            "nev" => "2Tesz",
            "konyv_id" => 14,
            "tipus" => "istvan",
            "hossz" => 3
        ],
        [
            "nev" => "1Tesz",
            "konyv_id" => 13,
            "tipus" => "istvan",
            "hossz" => 5
        ],
        [
            "nev" => "ApCsel",
            "konyv_id" => 5,
            "tipus" => "istvan",
            "hossz" => 28
        ],
        [
            "nev" => "3Ján",
            "konyv_id" => 25,
            "tipus" => "jeromos",
            "hossz" => 1
        ],
        [
            "nev" => "2Ján",
            "konyv_id" => 24,
            "tipus" => "jeromos",
            "hossz" => 1
        ],
        [
            "nev" => "1Ján",
            "konyv_id" => 23,
            "tipus" => "jeromos",
            "hossz" => 5
        ],
        [
            "nev" => "2Pét",
            "konyv_id" => 22,
            "tipus" => "jeromos",
            "hossz" => 3
        ],
        [
            "nev" => "1Pét",
            "konyv_id" => 21,
            "tipus" => "jeromos",
            "hossz" => 5
        ],
        [
            "nev" => "Csel",
            "konyv_id" => 5,
            "tipus" => "jeromos",
            "hossz" => 28
        ]
    ];

    private $newBooks =
        [[
            "nev" => "Ter",
            "konyv_id" => "101",
            "hossz" => 50,
            "tipus" => "default"
        ],
            [
                "nev" => "Kiv",
                "konyv_id" => "102",
                "hossz" => 40,
                "tipus" => "default"
            ],
            [
                "nev" => "Lev",
                "konyv_id" => "103",
                "hossz" => 27,
                "tipus" => "default"
            ],
            [
                "nev" => "Szám",
                "konyv_id" => "104",
                "hossz" => 36,
                "tipus" => "default"
            ],
            [
                "nev" => "MTörv",
                "konyv_id" => "105",
                "hossz" => 34,
                "tipus" => "default"
            ],
            [
                "nev" => "Józs",
                "konyv_id" => "106",
                "hossz" => 24,
                "tipus" => "default"
            ],
            [
                "nev" => "JudgA",
                "konyv_id" => "107",
                "hossz" => 21,
                "tipus" => "default"
            ],
            [
                "nev" => "Rút",
                "konyv_id" => "108",
                "hossz" => 4,
                "tipus" => "default"
            ],
            [
                "nev" => "1Sám",
                "konyv_id" => "109",
                "hossz" => 31,
                "tipus" => "default"
            ],
            [
                "nev" => "2Sám",
                "konyv_id" => "110",
                "hossz" => 24,
                "tipus" => "default"
            ],
            [
                "nev" => "1Kir",
                "konyv_id" => "111",
                "hossz" => 22,
                "tipus" => "default"
            ],
            [
                "nev" => "2Kir",
                "konyv_id" => "112",
                "hossz" => 25,
                "tipus" => "default"
            ],
            [
                "nev" => "1Krón",
                "konyv_id" => "113",
                "hossz" => 29,
                "tipus" => "default"
            ],
            [
                "nev" => "2Krón",
                "konyv_id" => "114",
                "hossz" => 36,
                "tipus" => "default"
            ],
            [
                "nev" => "Ezd",
                "konyv_id" => "115",
                "hossz" => 23,
                "tipus" => "default"
            ],
            [
                "nev" => "TobBA",
                "konyv_id" => "117",
                "hossz" => 14,
                "tipus" => "default"
            ],
            [
                "nev" => "Jud",
                "konyv_id" => "118",
                "hossz" => 16,
                "tipus" => "default"
            ],
            [
                "nev" => "Eszt",
                "konyv_id" => "119",
                "hossz" => 10,
                "tipus" => "default"
            ],
            [
                "nev" => "Jób",
                "konyv_id" => "120",
                "hossz" => 42,
                "tipus" => "default"
            ],
            [
                "nev" => "Zsolt",
                "konyv_id" => "121",
                "hossz" => 151,
                "tipus" => "default"
            ],
            [
                "nev" => "Péld",
                "konyv_id" => "122",
                "hossz" => 31,
                "tipus" => "default"
            ],
            [
                "nev" => "Préd",
                "konyv_id" => "123",
                "hossz" => 12,
                "tipus" => "default"
            ],
            [
                "nev" => "Én",
                "konyv_id" => "124",
                "hossz" => 8,
                "tipus" => "default"
            ],
            [
                "nev" => "Bölcs",
                "konyv_id" => "125",
                "hossz" => 19,
                "tipus" => "default"
            ],
            [
                "nev" => "Sir",
                "konyv_id" => "126",
                "hossz" => 51,
                "tipus" => "default"
            ],
            [
                "nev" => "Iz",
                "konyv_id" => "127",
                "hossz" => 66,
                "tipus" => "default"
            ],
            [
                "nev" => "Jer",
                "konyv_id" => "128",
                "hossz" => 52,
                "tipus" => "default"
            ],
            [
                "nev" => "Siral",
                "konyv_id" => "129",
                "hossz" => 5,
                "tipus" => "default"
            ],
            [
                "nev" => "Bár",
                "konyv_id" => "130",
                "hossz" => 5,
                "tipus" => "default"
            ],
            [
                "nev" => "Ez",
                "konyv_id" => "131",
                "hossz" => 48,
                "tipus" => "default"
            ],
            [
                "nev" => "Dán",
                "konyv_id" => "132",
                "hossz" => 12,
                "tipus" => "default"
            ],
            [
                "nev" => "(Zsuzs)",
                "konyv_id" => "133",
                "hossz" => 1,
                "tipus" => "default"
            ],
            [
                "nev" => "(Bél)",
                "konyv_id" => "134",
                "hossz" => 1,
                "tipus" => "default"
            ],
            [
                "nev" => "Oz",
                "konyv_id" => "135",
                "hossz" => 14,
                "tipus" => "default"
            ],
            [
                "nev" => "Jo",
                "konyv_id" => "136",
                "hossz" => 4,
                "tipus" => "default"
            ],
            [
                "nev" => "Ám",
                "konyv_id" => "137",
                "hossz" => 9,
                "tipus" => "default"
            ],
            [
                "nev" => "Abd",
                "konyv_id" => "138",
                "hossz" => 1,
                "tipus" => "default"
            ],
            [
                "nev" => "Jón",
                "konyv_id" => "139",
                "hossz" => 4,
                "tipus" => "default"
            ],
            [
                "nev" => "Mik",
                "konyv_id" => "140",
                "hossz" => 7,
                "tipus" => "default"
            ],
            [
                "nev" => "Náh",
                "konyv_id" => "141",
                "hossz" => 3,
                "tipus" => "default"
            ],
            [
                "nev" => "Hab",
                "konyv_id" => "142",
                "hossz" => 3,
                "tipus" => "default"
            ],
            [
                "nev" => "Szof",
                "konyv_id" => "143",
                "hossz" => 3,
                "tipus" => "default"
            ],
            [
                "nev" => "Agg",
                "konyv_id" => "144",
                "hossz" => 2,
                "tipus" => "default"
            ],
            [
                "nev" => "Zak",
                "konyv_id" => "145",
                "hossz" => 14,
                "tipus" => "default"
            ],
            [
                "nev" => "Mal",
                "konyv_id" => "146",
                "hossz" => 3,
                "tipus" => "default"
            ],
            [
                "nev" => "1Mak",
                "konyv_id" => "147",
                "hossz" => 16,
                "tipus" => "default"
            ],
            [
                "nev" => "2Mak",
                "konyv_id" => "148",
                "hossz" => 15,
                "tipus" => "default"
            ],
            [
                "nev" => "3Mak",
                "konyv_id" => "149",
                "hossz" => 7,
                "tipus" => "default"
            ],
            [
                "nev" => "4Mak",
                "konyv_id" => "150",
                "hossz" => 18,
                "tipus" => "default"
            ],
            [
                "nev" => "JerLev",
                "konyv_id" => "151",
                "hossz" => 1,
                "tipus" => "default"
            ],
            [
                "nev" => "Ezd3",
                "konyv_id" => "152",
                "hossz" => 9,
                "tipus" => "default"
            ],
            [
                "nev" => "Ód",
                "konyv_id" => "153",
                "hossz" => 14,
                "tipus" => "default"
            ],
            [
                "nev" => "SalZsolt",
                "konyv_id" => "154",
                "hossz" => 18,
                "tipus" => "default"
            ],
            [
                "nev" => "JoshA",
                "konyv_id" => "155",
                "hossz" => 19,
                "tipus" => "default"
            ],
            [
                "nev" => "Bír",
                "konyv_id" => "156",
                "hossz" => 21,
                "tipus" => "default"
            ],
            [
                "nev" => "Tób",
                "konyv_id" => "157",
                "hossz" => 14,
                "tipus" => "default"
            ],
            [
                "nev" => "DanTh",
                "konyv_id" => "158",
                "hossz" => 12,
                "tipus" => "default"
            ],
            [
                "nev" => "SusTh",
                "konyv_id" => "159",
                "hossz" => 1,
                "tipus" => "default"
            ],
            [
                "nev" => "BelTh",
                "konyv_id" => "160",
                "hossz" => 1,
                "tipus" => "default"
            ],
            [
                "nev" => "Mt",
                "konyv_id" => "201",
                "hossz" => 28,
                "tipus" => "default"
            ],
            [
                "nev" => "Mk",
                "konyv_id" => "202",
                "hossz" => 16,
                "tipus" => "default"
            ],
            [
                "nev" => "Lk",
                "konyv_id" => "203",
                "hossz" => 24,
                "tipus" => "default"
            ],
            [
                "nev" => "Jn",
                "konyv_id" => "204",
                "hossz" => 21,
                "tipus" => "default"
            ],
            [
                "nev" => "Acs",
                "konyv_id" => "205",
                "hossz" => 28,
                "tipus" => "default"
            ],
            [
                "nev" => "Róm",
                "konyv_id" => "206",
                "hossz" => 16,
                "tipus" => "default"
            ],
            [
                "nev" => "1Kor",
                "konyv_id" => "207",
                "hossz" => 16,
                "tipus" => "default"
            ],
            [
                "nev" => "2Kor",
                "konyv_id" => "208",
                "hossz" => 13,
                "tipus" => "default"
            ],
            [
                "nev" => "Gal",
                "konyv_id" => "209",
                "hossz" => 6,
                "tipus" => "default"
            ],
            [
                "nev" => "Ef",
                "konyv_id" => "210",
                "hossz" => 6,
                "tipus" => "default"
            ],
            [
                "nev" => "Fil",
                "konyv_id" => "211",
                "hossz" => 4,
                "tipus" => "default"
            ],
            [
                "nev" => "Kol",
                "konyv_id" => "212",
                "hossz" => 4,
                "tipus" => "default"
            ],
            [
                "nev" => "1Tessz",
                "konyv_id" => "213",
                "hossz" => 5,
                "tipus" => "default"
            ],
            [
                "nev" => "2Tessz",
                "konyv_id" => "214",
                "hossz" => 3,
                "tipus" => "default"
            ],
            [
                "nev" => "1Tim",
                "konyv_id" => "215",
                "hossz" => 6,
                "tipus" => "default"
            ],
            [
                "nev" => "2Tim",
                "konyv_id" => "216",
                "hossz" => 4,
                "tipus" => "default"
            ],
            [
                "nev" => "Tit",
                "konyv_id" => "217",
                "hossz" => 3,
                "tipus" => "default"
            ],
            [
                "nev" => "Filem",
                "konyv_id" => "218",
                "hossz" => 1,
                "tipus" => "default"
            ],
            [
                "nev" => "Zsid",
                "konyv_id" => "219",
                "hossz" => 13,
                "tipus" => "default"
            ],
            [
                "nev" => "Jak",
                "konyv_id" => "220",
                "hossz" => 5,
                "tipus" => "default"
            ],
            [
                "nev" => "1Pt",
                "konyv_id" => "221",
                "hossz" => 5,
                "tipus" => "default"
            ],
            [
                "nev" => "2Pt",
                "konyv_id" => "222",
                "hossz" => 3,
                "tipus" => "default"
            ],
            [
                "nev" => "1Jn",
                "konyv_id" => "223",
                "hossz" => 5,
                "tipus" => "default"
            ],
            [
                "nev" => "2Jn",
                "konyv_id" => "224",
                "hossz" => 1,
                "tipus" => "default"
            ],
            [
                "nev" => "3Jn",
                "konyv_id" => "225",
                "hossz" => 1,
                "tipus" => "default"
            ],
            [
                "nev" => "Jel",
                "konyv_id" => "227",
                "hossz" => 22,
                "tipus" => "default"
            ],
            [
                "nev" => "Didaché",
                "konyv_id" => "301",
                "hossz" => 16,
                "tipus" => "default"
            ],
            [
                "nev" => "Credo",
                "konyv_id" => "302",
                "hossz" => 1,
                "tipus" => "default"
            ]
        ];
}