<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display()
    {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    private function cmp($a, $b) {
        return strcmp($a['rank'], $b['rank']);
    }

    public function search() {

        $results = [];
        if ($this->request->is('post')) {
            
            $cmd = "cd /home/hadoop/Documents/Page_Rank_WikiPedia/;  java -jar InvertedIndexer.jar input/ \"" . $this->request->data['text'] . "\"";         
            exec ($cmd, $output, $return_var);

            $titles = [];
            for ($i = 0; $i < sizeof($output); $i += 2) {
                array_push($titles, $output[$i]);
                $results[$output[$i]] = ["content" => $output[$i + 1], "rank" => 0.0, "title" => $output[$i]];
            }

            if (sizeof($titles) > 0) {
                $pages = TableRegistry::get('Pages');
                $page_rank = $pages->find('all')->where(['title IN' => $titles]);

                //debug($cmd);
                //debug($titles);

                foreach ($page_rank as $key => $pr) {
                    $results[$pr->title]["rank"] = $pr->value;
                }
            }
            //$results = ['Billy_Butler_(footballer)' => [ 'rank' => 0.15 ], 'John_Williams_Stoddard' => [ 'rank' => 0.45 ], '1903_in_New_Zealand' => [ 'rank' => 0.35 ]];

            usort($results, function($a, $b) { return $a['rank'] < $b['rank']; });
            //debug($results);
            
            //debug($data->toArray()); exit();
            /*$article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));*/

            //$output = ["Billy Butler (footballer)", "{{for|similarly named people|William Butler}} {{unreferenced|date=June 2008}} '''William Butler''' (1901 in [[Atherton, Greater Manchester|Atherton]], [[Lancashire]] ??? July 1966) was an [[England|English]] professional [[football (soccer)|footballer]] who was most famously a [[Midfielder#Winger|winger]] for [[Bolton Wanderers F.C.|Bolton Wanderers]] in the 1920s.  Billy Butler had never played for any form of organised football team prior to joining the army. He played as a centre-forward for his regiment and on leaving the army he joined his hometown club [[Atherton F.C.|Atherton]] at the age of 19. He moved to [[Bolton Wanderers F.C.|Bolton Wanderers]] in April 1920 and, on moving to the right wing, soon established himself. He played in the 1923 [[FA Cup Final]] victory over [[West Ham United F.C.|West Ham United]], the famous first [[Wembley Stadium (1923)|Wembley]] final, and the following year, on [[April 12]], [[1929]], made his [[England national football team|England]] debut against [[Scotland national football team|Scotland]].   It was to be his only appearance for the England national team, but he was back at Wembley again for the 1926 FA Cup Final win over [[Manchester City F.C.|Manchester City]], and picked up his third winners medal in 1929, scoring the opening goal in the 2-0 defeat of [[Portsmouth F.C.|Portsmouth]].   On Bolton's relegation in 1933, Bulter asked for a transfer and left to join his former Bolton team-mate [[Joe Smith (footballer)|Joe Smith]], who by now was manager of [[Reading F.C.|Reading]]. He had played 449 games for Bolton, scoring 74 goals.  In August 1935, Smith left to manage [[Blackpool F.C.|Blackpool]] and Butler took over the reigns at Reading and carried on with the good work Smith had started. Reading never finished below 6th place in [[Division Three (South)]] during Butler's tenure and were heading for another top five finish when he resigned in February 1939.   He became manager of [[Guildford City F.C.|Guildford City]], but then the [[World War II|war]] intervened and Butler joined the [[Royal Air Force|RAF]] as a [[Physical education|PT]] instructor. With the war over, Butler was appointed manager of [[Torquay United F.C.|Torquay United]] in August 1945, but left [[Plainmoor]] in May 1946 before [[Football League|league football]] had resumed.   He subsequently moved to [[South Africa]] to manage [[Johannesburg Rangers F.C.|Johannesburg Rangers]], where he discovered the future [[Wolverhampton Wanderers|Wolves]] defender [[Eddie Stuart]]. He was later a coach for the Pietermaritzburg &amp; District Football Association and then a coach for the Rhodesian Football Association  Butler died in [[Durban]] in July 1966, aged 66.  {{start box}} {{succession box|  before=?|  title=[[Guildford City F.C.|Guildford&amp;nbsp;City&amp;nbsp;Manager ]]|  years=1939-[[?]]|  after=? }} {{end box}} {{Reading F.C. managers}} {{Torquay United F.C. managers}}  {{DEFAULTSORT:Butler, Billy}} [[Category:English footballers]] [[Category:England international footballers]] [[Category:Football (soccer) wingers]] [[Category:Bolton Wanderers F.C. players]] [[Category:Reading F.C. players]] [[Category:Reading F.C. managers]] [[Category:Torquay United F.C. managers]] [[Category:People from Atherton, Greater Manchester]] [[Category:1900 births]] [[Category:1966 deaths]] [[Category:The Football League players]]", "Wikipedia:Picture of the day/March 14, 2006", "&lt;!--If you make a correction to the text below, please also check the article the text came from. --&gt; {| width=600 cellspacing=5 style=&quot;border-style:solid;border-color:#ccccff;padding:5px;text-align:center;&quot;  |colspan=&quot;2&quot; align=&quot;center&quot;| &lt;font size=&quot;+1&quot;&gt;[[Wikipedia:Picture of the day|Picture of the day]]&lt;/font&gt; |---- |[[Image:Dscn3200-2-butterflies.jpg|350px|Two butterflies feed on a small lump of feces lying on a rock]] | A '''[[butterfly]]''' is a flying [[insect]]. When touched by humans, they tend to lose some scales, that look like a fine powder.  If they lose too many scales, their ability to fly will be impaired.  People who study or collect butterflies (or the closely related [[moth]]s) are called [[lepidopterist|lepidopterists]].  &lt;small&gt;Photo credit: [[User:William M. Connolley|William M. Connolley]]&lt;/small&gt;&lt;br&gt; &lt;small&gt;[[Wikipedia:Picture_of_the_day/{{CURRENTMONTHNAME}} {{CURRENTYEAR}}|Archive]] - [[Wikipedia:Featured picture candidates|Nominate new image]]&lt;/small&gt; |}"];
            
        }
        $this->set('results', $results);        
    }
}
