<?php
namespace app\index\controller;

use think\Request;
use think\Db;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }


    public function get(Request $request)
    {
      $param = $request->param();
      // $GLOBALS['allData'] = [];
      $allData = [];
      $data = null;
      // sy_user: {
      //     id: 55,
      //     "@column":"id, balance, intergral, icon, is_vip, mobile, surename, username"
      // }
      foreach ($param as $table => $where) {

        if (endsWith($table, '[]')) {
          $content = $where;
          $sub = $table;
          foreach ($content as $table => $where) {

            // 这里应该使用递归  start
            if (endsWith($table, '[]')) {
              $content = $where;
              $sub = $table;
              foreach ($content as $table => $where) {
                $data = Db::table($table);
                foreach ($where as $field => $condition) {
                  if ($field === "@column") {
                    $data = $data->field($condition);
                    continue;
                  }
                  if (endsWith($field, '@')) {
                    $field = substr($field, 0, -1);
                    list($items, $withTable, $withKey) = explode("/", $condition);
                    foreach ($allData[$items] as $keyNum => $item) {
                      $data1 = clone $data;
                      $data1 = $data1->where($field, $allData[$items][$keyNum][$withKey]);
                      $allData[$items][$keyNum][$sub] = $data1->select();
                      // $allData[$items][$keyNum][$sub] = $data->select();
                      // $allData[$items][$keyNum][$sub] = $data->getLastSql();
                    }
                    continue;
                  }
                }
              }
              continue;
            }
            // 这里应该使用递归  end


            $data = Db::table($table);
            // $data = clone $data1;
            foreach ($where as $field => $condition) {
              if (endsWith($field, '@')) {
                $field = substr($field, 0, -1);
                // list($withTable, $withKey) = explode("/", $condition);
                // list($items, $withTable, $withKey) = explode("/", $condition);
                $explodeArr = explode("/", $condition);
                if (count($explodeArr) == 3) {
                  // list($items, $withTable, $withKey) = $explodeArr;
                //   // $data = $data->where($field, $allData[$items][$withTable][$withKey]);
                  // $allData['aaaaa'] = $allData[$items][$withTable][$withKey];
                  $allData['aaaaa'] = $explodeArr;
                }elseif (count($explodeArr) == 2) {
                  list($withTable, $withKey) = $explodeArr;
                  $data = $data->where($field, $allData[$withTable][$withKey]);
                }
                continue;
              }
              if ($field === "@column") {
                $data = $data->field($condition);
                continue;
              }

              $data = $data->where($field, $condition);
              // $allData['dddd'] .= $allData['dddd'] ? $allData['dddd'] : $table;
              $allData['sub'] = $sub;
              $allData['table'] = $table;
              // $allData[$sub][$table] = $data->select();

            }

            // $allData[$sub][$table] = $data->select();
            $allData[$sub] = $data->order('id','desc')->select();
          }
          continue;
        }
        $data = Db::table($table);
        foreach ($where as $field => $condition) {
          if ($field === "@column") {
            $data = $data->field($condition);
            continue;
          }

          $data = $data->where($field, $condition);
        }
        $allData[$table] = $data->find();
      }
      return json($allData);


    }

    public function post(Request $request)
    {
      // config('app.app_trace', false);
      $allowField = [
        // 'username' => 'username',
        // 'surename' => 'surename',
        // 'mobile' => 'mobile',
        // 'openid' => 'openid',
        // 'icon' => 'icon',
      ];
      $param = $request->param();
      $tableName = array_key_first($param);
      $data = Db::table($tableName)->insertGetId($param[$tableName]);
      $result = Db::table($tableName)->find($data);
      return json($result);
    }

    public function delete(Request $request)
    {
      $param = $request->param();
      $tableName = array_key_first($param);
      $result = Db::table($tableName)->delete($param[$tableName]['ids']);
      return $result;
    }

    public function put(Request $request)
    {
      $param = $request->param();
      $tableName = array_key_first($param);
      return Db::table($tableName)->update($param[$tableName]);
    }






}


