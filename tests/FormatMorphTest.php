<?php

use App\Http\Controllers\TextController;

class FormatMorphTest extends TestCase {

    public function testSentenceAnalysis()
    {
        $ctrl = new TextController();
        $formatted = $ctrl->formatMorphs("f.sing.dat(si).(acc. cum inf.)");
        $this->assertEquals("<abbr class='morph'>f.</abbr> <abbr class='morph'>sing.</abbr> <abbr class='morph'>dat(si).</abbr><abbr class='morph'>(acc. cum inf.)</abbr>", $formatted);
    }
}
