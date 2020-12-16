<?php namespace MarkDai\SayitPlugin\Models;

use Model;

/**
 * Model
 */
class Debate extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'markdai_sayitplugin_debate';

    public $hasMany = [
        'sections' => ['MarkDai\SayitPlugin\Models\DebateSection','delete' => true]
    ];

    public function afterSave()
    {
        $content = $this->getAnContent($this->anurl);

        foreach($content->debate->debateBody->debateSection as $debateSection)
        {
            $this->beforeUpdate();
            $section = new DebateSection;
            $section->debate_id = $this->id;
            $section->heading = $debateSection->heading;
            $section->save();

            foreach($debateSection->speech as $debateSpeech)
            {
                $speech = new DebateSectionSpeech;
                $speech->debate_section_id = $section->id;
                $speech->speaker = $debateSpeech->attributes()->by;
                if ( is_string( $debateSpeech->p ) ) {
                    $speech->speech = $debateSpeech->p;
                } else {
                    $speech->speech = str_replace( '</p>', '', str_replace( '<p>', '', $debateSpeech->p->asXML() ) );
                }
                $speech->save();
            }
        }
    }

    public function beforeUpdate()
    {
        $debate = Debate::find($this->id);
        $sections = $debate->sections()->get();
        foreach ($sections as $section) {
            $section->delete();
        }
    }

    public function getAnContent($url)
    {
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36');
        $content = curl_exec($ch); 
        curl_close($ch); 
        return simplexml_load_string($content);
    }
}
