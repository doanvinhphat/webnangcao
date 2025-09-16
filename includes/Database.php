<?php
if(!defined('_INCODE')) die('Truy cập bị từ chối!');

//hàm thực hiện truy vấn
function query($sql, $data = [], $statementStatus = false)
{
    global $conn;
    $query = false;
    try {
        $statement = $conn->prepare($sql);

        if (empty($data)) {
            $query = $statement->execute();
        } else {
            $query = $statement->execute($data);
        }
    } catch (Exception $e) {

        require_once 'modules/errors/database.php'; //Import error
        die(); //Dừng hết chương trình
    }

    if ($statementStatus && $query) {
        return $statement;
    }

    return $query;
}
//hàm thêm dữ liệu
function insert($table, $dataInsert)
{

    $keyArr = array_keys($dataInsert);
    $fieldStr = implode(', ', $keyArr);
    $valueStr = ':' . implode(', :', $keyArr);

    $sql = 'INSERT INTO `' . $table . '`(' . $fieldStr . ') VALUES(' . $valueStr . ')';

    return query($sql, $dataInsert);
}
//hàm cập nhật
function update($table, $dataUpdate, $condition = '')
{

    $updateStr = '';
    foreach ($dataUpdate as $key => $value) {
        $updateStr .= $key . '=:' . $key . ', ';
    }

    $updateStr = rtrim($updateStr, ', ');

    if (!empty($condition)) {
        $sql = 'UPDATE `' . $table . '` SET ' . $updateStr . ' WHERE ' . $condition;
    } else {
        $sql = 'UPDATE `' . $table . '` SET ' . $updateStr;
    }

    return query($sql, $dataUpdate);
}
//hàm xóa
function delete($table, $condition = '')
{
    if (!empty($condition)) {
        $sql = "DELETE FROM `$table` WHERE $condition";
    } else {
        $sql = "DELETE FROM `$table`";
    }

    return query($sql);
}

//truy vấn lấy dòng, lấy chi tiết 
function first($sql, $data = [])
{
    $statement = query($sql, $data, true);
    if ($statement) {
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}

//truy vấn lấy nhiều bản, lấy danh sách
function getRows($sql, $data = [])
{
    $statement = query($sql, $data, true);
    if ($statement) {
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
}

//kiểm tra trùng thông tin
function checkExists($table, $field, $value)
{
    $sql = "SELECT * FROM `$table` WHERE `$field` = :value LIMIT 1";
    $result = first($sql, ['value' => $value]);
    return $result ? true : false;
}