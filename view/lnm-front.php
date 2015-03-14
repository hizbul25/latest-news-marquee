<?php
require_once(LNM_PLUGIN_PATH . '/inc/libs/simple_html_dom.php');

class LNM_Front {
    protected $news_paper_id;
    protected $latest_news = array();
    public function __construct() {
        add_shortcode('news_paper', array($this, 'get_news_paper_id'));
    }

    public function get_news_paper_id($attr) {
        $default = array(
            'id'    => 1,
        );

        $this->news_paper_id = shortcode_atts($default, $attr);
        $news_paper_url = $this->get_news_paper_url($this->news_paper_id['id']);
        $dom = file_get_html($news_paper_url);
        $latest_news_marquee = '';
        switch($this->news_paper_id['id']) {
            case 1:
                $latest_news_marquee = $this->prothom_alo($dom);
                break;
            case 2:
                $latest_news_marquee = $this->dailystar($dom);
                break;
        }

        $news_papers = get_option('lnm_option_name');
        ob_start();
        ?>
        <div class="display-marquee">
            <label class="marquee-label" style="color: <?php echo $news_papers['lnm_label_color']; ?>"><?php echo $news_papers['lnm_news_label_id']; ?>:</label>
            <ul class="newsticker latest-news">
                <?php foreach($latest_news_marquee as $marquee) {?>
                    <li style="color: <?php echo $news_papers['lnm_news_color'] ?>"><?php echo $marquee; ?></li>
               <?php } ?>
            </ul>
        </div>
        <?php
        $news_content = ob_get_clean();
        return $news_content;
    }

    private function get_news_paper_url($id) {
        $paper_url = array(
            1   => 'http://prothom-alo.com/',
            2   => 'http://www.thedailystar.net/'
        );
        return $paper_url[$id];
    }

    private function prothom_alo($dom) {
        foreach($dom->find('a.each_slide') as $id => $marquee) {
            $this->latest_news[$id] = $marquee->plaintext;
            if($id >= 4) {
                break;
            }
        }
        return $this->latest_news;
    }

    private function dailystar($dom) {
        foreach($dom->find('ul.list-border li') as $id => $marquee) {
            $this->latest_news[$id] = $marquee->plaintext;
            if($id >= 4) {
                break;
            }
        }

        return $this->latest_news;
    }
}

$obj_lnm_front = new LNM_Front();