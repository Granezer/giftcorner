<?php

/**
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class Library {

    public function __construct() {
        date_default_timezone_set("Africa/Lagos");
    }

    /**
     * @param int $days
     * @return array
     *
    */
    public function getFormatedDateTime($days) {
        
        return date("Y-m-d H:i:s", strtotime('+'.$days.' days',
                strtotime(date("Y-m-d H:i:s"))
            )
        );
    }

    /**
     * @param string $email
     * @return string
     *
    */
    public function generateCode($digits = 8) {

        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        while($i < $digits){
            //generate a random number between 0 and 9.
            $pin .= mt_rand(0, 9);
            $i++;
        }
        
        return $pin;
    }

    public function generateTransactionId() {
        $t = microtime(true);
        $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
        $d = new DateTime(date("Y-m-d H:i:s.".$micro,$t));
        $now = $d->format("Y-m-d H:i:s:u:v");
        $code = str_shuffle($now);
        $code = strtoupper(md5($code));

        return $code;
    }

    public function generateDeviceIdAndName() {
        $t = microtime(true);
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
        $now = $d->format("Y-m-d H:i:s:u:v"); // note at point on "u"
        $device_id = md5($now);
        $length = 200;
        $device_id .= substr(
            str_shuffle(
                str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 
                    ceil($length/strlen($x)) )
            ),1,$length
        );
        $device_name = time(); 

        return array(
            "device_id" => $device_id, 
            "device_name" => $device_name, 
            "current_time" => time()
        );
    }

    public function formatResponse($data = array(), $pagination = array(), $sort = array(), $query = array(), $request = array()) {

        $alldata = $data;
        // echo json_encode($request); exit;
        $datatable = array_merge(
            array(
                'pagination' => $pagination, 
                'sort' => $sort, 
                'query' => $query,
                $request
            )
        );

        // search filter by keywords
        $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch']) ? $datatable['query']['generalSearch'] : '';
        if (!empty($filter)) {
            $data = array_filter($data, function ($a) use ($filter) {
                return (boolean)preg_grep("/$filter/i", (array)$a);
            });
            unset($datatable['query']['generalSearch']);
        }

        // filter by field query
        $query = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
        if (is_array($query)) {
            $query = array_filter($query);
            foreach ($query as $key => $val) {
                $data = list_filter($data, array($key => $val));
            }
        }

        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'desc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'id';

        $meta = array();
        $page = !empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

        $pages = 1;
        $total = count($data); // total items in array

        // sort
        // usort($data, function ($a, $b) use ($sort, $field) {
        //     if (!isset($a->$field) || !isset($b->$field)) {
        //         return false;
        //     }

        //     if ($sort === 'asc') {
        //         return $a->$field > $b->$field ? true : false;
        //     }

        //     return $a->$field < $b->$field ? true : false;
        // });

        // $perpage 0; get all data
        $offset = 0;
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }

            $data = array_slice($data, $offset, $perpage, true);
        }

        $meta = array(
            'page' => $page,
            'pages' => $pages,
            'perpage' => $perpage,
            'total' => $total,
            'current_total_records' => count($data) + $offset,
        );

        // if selected all records enabled, provide all the ids
        if (isset($datatable['requestIds']) && filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN)) {
            $meta['rowIds'] = array_map(function ($row) {
                foreach ($row as $first) break;
                return $first;
            }, $alldata);
        }

        $results = array(
            'meta' => $meta + array(
                    'sort' => $sort,
                    'field' => $field,
                ),
            'data' => $data,
            'success' => true
        );

        return $results;
    }

    public function formatSingleResponse($data) {

        $results = array(
            'data' => $data,
            'success' => true
        );

        return $results;
    }

}
