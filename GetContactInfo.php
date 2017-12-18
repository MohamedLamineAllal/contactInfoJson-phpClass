<?php
/**
 * doc
 */
class ContactInfo
{
    private $_infoData = array();

    /**
     * doc
     */
    public function __construct($contactJson, $dataAssoArray = null) {
        if ($dataAssoArray === null) { // case there is no Argument
            
            if (file_exists($contactJson)) {
                if ($contactFile = fopen($contactJson, 'r')) {
                    $jsonData = fread($contactFile, filesize($contactJson));
                    $this->_infoData = json_decode($jsonData, true);
                } else {
                    die("file couldn't be opened");
                }
            }
        }
    }
    
    /**
     * a link contact is a contact that is composed of a text describing it (title) and a link.
     * [
     *      'text' => "click here", 
     *      'href' => "../here/my/link.html"
     * 
     * ]
     */
    public function isLinkContact($assocArrayToTest)
    {
        if (!isset($assocArrayToTest['href'])) {
            return false;
        }
        return true;
    }

    /**
     *  see above (keyword: link contact)
     */
    public function getLinkTagElementFromLinkContact($linkContactAssoArray) {
        return "<a href=\"".$linkContactAssoArray['href']."\">".$linkContactAssoArray['text']."</a>";
    }
     /**
     * doc
     */
    public function printDataInfoHTML_formatList1($idClassarray = null)
    {
        $id = "";
        $class = "";
        
        if ($idClassarray != null) {
            if (!empty($idClassarray["id"])) {
                $id =  "id=\"".$idClassarray["id"]."\"";
            }
            if (!empty($idClassarray["class"])) {
                $class =  "class=\"".$idClassarray["class"]."\"";
            }           
        } 

        $str_result = "<ul $id $class>\n";
        foreach ($this->_infoData as $infoType => $value) {
            $str_result .= "\t<li><strong>$infoType</strong>: ";
            if (is_string($value)) {
                $str_result .= "<span>".$value."</span></li>\n";
            } else { // it's a dictionnary
                if ($this->isLinkContact($value)) { // the assoc array is a linkContact
                    $str_result .=  $this->getLinkTagElementFromLinkContact($value)."</li>\n";// <a href="link/here">text here</a></li>  
                } else if (count($value) == 1) { //assoc array is just "1" => value
                    if ($this->isLinkContact($value["1"])) { // if value is a link contact
                        $str_result .= $this->getLinkTagElementFromLinkContact($value["1"])."</li>\n"; 
                    } else {
                        $str_result .= "<span>".$value['1']."</span></li>\n";
                    }
                } else { // there is multiple contact for this one type
                    $str_result .= "\t\t<ul>\n";
                    foreach ($value as $num => $infoValue) {
                        $str_result .= "\t\t\t<li><span>$num</span>: ";
                        if (is_string($infoValue)) {
                            $str_result .= "<span>$infoValue</span></li>\n";
                        } else if ($this->isLinkContact($infoValue)) { // is a linkContact
                            $str_result .= $this->getLinkTagElementFromLinkContact($infoValue) ."</li>\n";
                        }   
                    }
                    $str_result .= "\t\t</ul>\n
                \t</li>\n";
                }
            }
             
        }
        $str_result .= "</ul>\n";
        return $str_result;
    }
};

// others format may be added later (like something else then linkContact)