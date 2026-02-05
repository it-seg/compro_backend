<?php
class DbCmd {
    private  $cmd;
    private  $sql;

    private $connection;
    private  $distinct;
    private $arrSelect;
    private  $arrFrom;
    private  $arrJoin;
    private  $arrWhere;
    private  $arrParams;
    private  $arrGroup;
    private  $arrOrder;
    private  $arrHaving;
    private  $arrUnion;
    private  $limit;
    private  $offset;
    private  $as;
    private  $arrUpdateFields;

    private static $inCounter = 0;

    /**
     * @return self
     */
    static public function instance(){
        return new self();
    }

    /**
     * DbCmd constructor.
     * @param string $table
     */
    public function __construct($table=''){
        $this->reset();
        $table && $this->addFrom($table);
        $this->connection = Yii::app()->db;
    }

    public function reset(){
        $this->arrSelect = [];
        $this->arrFrom = [];
        $this->arrJoin = [];
        $this->arrWhere = [];
        $this->arrParams = [];
        $this->arrGroup = [];
        $this->arrOrder = [];
        $this->arrHaving = [];
        $this->arrUnion = [];
        $this->limit = -1;
        $this->offset = -1;
        $this->as = false;
        $this->sql = [];
        $this->distinct = 0;
    }

    /**
     * @param CDbConnection $connection
     */
    public function setConnection($connection){
        $this->connection = $connection;
    }

    /**
     * @param array $params
     */
    private function _mergeParams($params = []){
        $this->arrParams = array_merge($this->arrParams, $params);
    }

    /**
     * @param string|self $table
     */
    private function _addFrom($table){
        if($table instanceof self){
            $this->arrFrom[] = '('.$table->getText().') AS '.($table->as? $table->as : 't'.count($this->arrFrom));
            $this->_mergeParams($table->arrParams);
        } else
            $this->arrFrom[] = $table;
    }

    /**
     * @param string|array|self $table
     * @return $this
     */
    public function addFrom($table){
        if(is_array($table)){
            foreach ($table as $t){
                $this->_addFrom($t);
            }
        } else
            $this->_addFrom($table);

        return $this;
    }

    /**
     * @param string|array|self $table
     * @return $this
     */
    public function from($table){
        return $this->addFrom($table);
    }

    /**
     * @param string|array|self $table
     * @return $this
     */
    public function setFrom($table){
        return $this->clearFrom()
            ->addFrom($table);
    }

    /**
     * @return $this
     */
    public function clearFrom(){
        $this->arrFrom = [];

        return $this;
    }

    const DISTINCT_NONE = 0;
    const DISTINCT = 1;
    const DISTINCT_ROW = 2;

    /**
     * @param string|array $fields
     * @param bool|integer $distinct
     * @return $this
     */
    public function addSelect($fields, $distinct=self::DISTINCT_NONE){
        if(is_array($fields)) $this->arrSelect = array_merge($this->arrSelect, $fields);
        else $this->arrSelect[] = $fields;

        $this->distinct = $distinct === true ? self::DISTINCT : ($distinct === false ? self::DISTINCT_NONE : $distinct);

        return $this;
    }

    /**
     * @param string|array $fields
     * @param bool|integer $distinct
     * @return self
     */
    public function select($fields, $distinct=self::DISTINCT_NONE){
        return $this->addSelect($fields, $distinct);
    }

    /**
     * @param string|array $fields
     * @return self
     */
    public function selectDistinct($fields){
        return $this->addSelect($fields, self::DISTINCT);
    }

    /**
     * @param string|array $fields
     * @return self
     */
    public function selectDistinctRow($fields){
        return $this->addSelect($fields, self::DISTINCT_ROW);
    }

    /**
     * @param string|array $fields
     * @param bool|integer $distinct
     * @return self
     */
    public function setSelect($fields, $distinct=self::DISTINCT_NONE){
        return $this->clearSelect()
            ->addSelect($fields, $distinct);
    }

    /**
     * @param int|string $index
     * @param mixed $fields
     * @return $this
     */
    public function updateSelect($index, $fields){
        $this->arrSelect[$index] = $fields;

        return $this;
    }

    /**
     * @param int|string $index
     * @param $fields
     * @return $this
     */
    public function removeSelect($index){
        unset($this->arrSelect[$index]);

        return $this;
    }

    /**
     * @return $this
     */
    public function clearSelect(){
        $this->arrSelect = [];
        $this->distinct = 0;
        return $this;
    }

    const Equal = '=';
    const NotEqual = '!=';

    /**
     * @param string $field1
     * @param string $field2
     * @param string $rule
     * @param string $operand
     * @return $this
     */
    public function addCompare($field1, $field2, $rule = self::Equal, $operand = 'AND'){
        if(count($this->arrWhere)) $this->arrWhere[] = $operand;
        $this->arrWhere[] = '(('.$field1.' IS NOT NULL AND '.$field2.' IS NOT NULL AND '.' '.$field1.$rule.' '.$field2.') OR '
            .($rule==self::Equal?'':'NOT').'('.$field1.' IS NULL AND '.$field2.' IS NULL))';

        return $this;
    }

    /**
     * @param string $field1
     * @param string $field2
     * @param string $rule
     * @param string $operand
     * @return $this
     */
    public function compare($field1, $field2, $rule = self::Equal, $operand = 'AND'){
        return $this->addCompare($field1, $field2, $rule, $operand);
    }

    const OperatorAND = 'AND';
    const OperatorOR = 'OR';

    /**
     * @param string|self $condition
     * @param string $operand
     * @return $this
     */
    private function _addCondition($condition, $operand = self::OperatorAND){
        if($condition instanceof self){
            $this->_mergeParams($condition->arrParams);
            $condition = $condition->getWhere();
        }elseif(count($this->arrWhere))
            $this->arrWhere[] = $operand;

        $this->arrWhere[] = '( '.$condition.' )';

        return $this;
    }

    /**
     * @param string|self $condition
     * @param string $operand
     * @return $this
     */
    public function addCondition($condition, $operand = self::OperatorAND){
        if(is_array($condition))
            foreach ($condition as $c) {
                $operand = strcasecmp($c, self::OperatorOR)? self::OperatorAND : self::OperatorOR;
                $this->_addCondition($c, $operand);
            }
        else
            $this->_addCondition($condition, $operand);

        return $this;
    }

    /**
     * @param string|array|self $condition
     * @param string $operand
     * @return $this
     */
    public function setCondition($condition, $operand = self::OperatorAND){
        return $this->clearCondition()
            ->addCondition($condition, $operand);
    }

    /**
     * @param string|array|self $condition
     * @param string $operand
     * @return $this
     */
    public function where($condition, $operand = self::OperatorAND){
        return $this->addCondition($condition, $operand);
    }

    /**
     * @param string|array|self $condition
     * @param string $operand
     * @return $this
     */
    public function setWhere($condition, $operand = self::OperatorAND){
        return $this->clearCondition()
            ->addCondition($condition, $operand);
    }

    /**
     * @param string $field
     * @param string $operand
     * @return $this
     */
    public function addIsNullCondition($field, $operand = self::OperatorAND){
        $this->_addCondition($field.' IS NULL', $operand);

        return $this;
    }

    /**
     * @param string $field
     * @param string $operand
     * @return $this
     */
    public function whereIsNull($field, $operand = self::OperatorAND){
        return $this->addIsNullCondition($field, $operand);
    }

    /**
     * @param string $field
     * @param string $operand
     * @return $this
     */
    public function addIsNotNullCondition($field, $operand = self::OperatorAND){
        $this->_addCondition($field.' IS NOT NULL', $operand);

        return $this;
    }

    /**
     * @param string $field
     * @param string $operand
     * @return $this
     */
    public function whereIsNotNull($field, $operand = self::OperatorAND){
        return $this->addIsNotNullCondition($field, $operand);
    }

    /**
     * @param string $field
     * @param string|array|self $values
     * @param string $operand
     * @return $this
     */
    public function addInCondition($field, $values, $operand = self::OperatorAND){
        $this->_addInOrNotInCondition('IN', $field, $values, $operand);

        return $this;
    }

    /**
     * @param string $field
     * @param string|array|self $values
     * @param string $operand
     * @return $this
     */
    public function whereIn($field, $values, $operand = self::OperatorAND){
        return $this->addInCondition($field, $values, $operand);
    }

    /**
     * @param string $field
     * @param string|array|self $values
     * @param string $operand
     * @return $this
     */
    public function addNotInCondition($field, $values, $operand = self::OperatorAND){
        $this->_addInOrNotInCondition('NOT IN', $field, $values, $operand);

        return $this;
    }

    /**
     * @param string $field
     * @param string|array|self $values
     * @param string $operand
     * @return $this
     */
    public function whereNotIn($field, $values, $operand = self::OperatorAND){
        return $this->addNotInCondition($field, $values, $operand);
    }

    /**
     * @param string $in
     * @param string $field
     * @param string|array|self $values
     * @param string $operand
     */
    private function _addInOrNotInCondition($in, $field, $values, $operand = self::OperatorAND){
        self::$inCounter++;
        if(count($this->arrWhere)) $this->arrWhere[] = $operand;
        $condition = $field." $in ( ";

        if($values instanceof self){
            $condition .= $values->getText();
            $this->arrParams = array_merge($this->arrParams, $values->arrParams);
        }else if(is_array($values)){
            for($i = 0; $i < count($values); $i++){
                if($i > 0 && $i < count($values)) $condition .= ' , ';
                $key = ":inOrNotIn".self::$inCounter.$i;
                $condition .= $key;
                $this->arrParams[$key] = $values[$i];
            }
        }else{
            $condition .= $values;
        }

        $this->arrWhere[] = $condition.' )';
    }

    /**
     * @return $this
     */
    public function clearCondition(){
        $this->arrWhere = [];

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function addParam($key, $value){
        $this->arrParams[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function param($key, $value){
        return $this->addParam($key, $value);
    }

    /**
     * @param array $params
     * @return $this
     */
    public function addParams($params=[]){
        if(is_array($params))
            $this->arrParams = array_merge($this->arrParams, $params);

        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function params($params=[]){
        return $this->addParams($params);
    }

    /**
     * @return $this
     */
    public function clearParam(){
        $this->arrParams = [];

        return $this;
    }

    const LEFT_JOIN = 'LEFT JOIN';
    const RIGHT_JOIN = 'RIGHT JOIN';
    const INNER_JOIN = 'INNER JOIN';

    /**
     * @param string|self $table
     * @param string|self $condition
     * @param string $join
     * @return $this
     */
    public function addJoin($table, $condition, $join = self::LEFT_JOIN){
        if($table instanceof self){
            $joinTable = '('.$table->getText().') AS '.($table->as? $table->as : 'jt'.count($this->arrJoin));
            $this->arrParams = array_merge($this->arrParams, $table->arrParams);
        }else{
            $joinTable = $table;
        }

        if($condition instanceof self){
            $this->_mergeParams($condition->arrParams);
            $condition = $condition->getWhere();
        }

        $this->arrJoin[] = ' ' . $join . ' ' . $joinTable . ' ON ' . $condition . ' ';

        return $this;
    }
    /**
     * @param string|self $table
     * @param string|self $condition
     * @param string $join
     * @return $this
     */
    public function join($table, $condition, $join = self::LEFT_JOIN){
        return $this->addJoin($table, $condition, $join);
    }

    /**
     * @param string|self $table
     * @param string|self $condition
     * @return $this
     */
    public function addLeftJoin($table, $condition){
        $this->addJoin($table, $condition, self::LEFT_JOIN);

        return $this;
    }

    /**
     * @param string|self $table
     * @param string|self $condition
     * @return $this
     */
    public function leftJoin($table, $condition){
        return $this->addJoin($table, $condition, self::LEFT_JOIN);
    }

    /**
     * @param string|self $table
     * @param string|self $condition
     * @return $this
     */
    public function addRightJoin($table, $condition){
        $this->addJoin($table, $condition, self::RIGHT_JOIN);

        return $this;
    }

    /**
     * @param string|self $table
     * @param string|self $condition
     * @return $this
     */
    public function rightJoin($table, $condition){
        return $this->addJoin($table, $condition, self::RIGHT_JOIN);
    }

    /**
     * @param string|self $table
     * @param string|self $condition
     * @return $this
     */
    public function addInnerJoin($table, $condition){
        $this->addJoin($table, $condition, self::INNER_JOIN);

        return $this;
    }

    /**
     * @param string|self $table
     * @param string|self $condition
     * @return $this
     */
    public function innerJoin($table, $condition){
        return $this->addJoin($table, $condition, self::INNER_JOIN);
    }

    /**
     * @return $this
     */
    public function clearJoin(){
        $this->arrJoin = [];

        return $this;
    }

    /**
     * @param string|array $fields
     * @return $this
     */
    public function addOrder($fields){
        if(is_array($fields)) $this->arrOrder = array_merge($this->arrOrder, $fields);
        else $this->arrOrder[] = $fields;

        return $this;
    }

    /**
     * @param string|array $fields
     * @return $this
     */
    public function orderBy($fields){
        return $this->addOrder($fields);
    }

    /**
     * @param string|array $fields
     * @return $this
     */
    public function setOrder($fields){
        return $this->clearOrder()
            ->addOrder($fields);
    }

    /**
     * @param string|array $fields
     * @return $this
     */
    public function setOrderBy($fields){
        return $this->clearOrder()
            ->addOrder($fields);
    }

    /**
     * @return $this
     */
    public function clearOrder(){
        $this->arrOrder = [];

        return $this;
    }

    /**
     * @param string|array $fields
     * @return $this
     */
    public function addGroup($fields){
        if(is_array($fields)) $this->arrGroup = array_merge($this->arrGroup, $fields);
        else $this->arrGroup[] = $fields;

        return $this;
    }

    /**
     * @param string|array $fields
     * @return $this
     */
    public function groupBy($fields){
        return $this->addGroup($fields);
    }

    /**
     * @param string|array $fields
     * @return $this
     */
    public function setGroup($fields){
        return $this->clearGroup()
            ->addGroup($fields);
    }

    /**
     * @param string|array $fields
     * @return $this
     */
    public function setGroupBy($fields){
        return $this->clearGroup()
            ->addGroup($fields);
    }

    /**
     * @return $this
     */
    public function clearGroup(){
        $this->arrGroup = [];

        return $this;
    }

    /**
     * @param string $condition
     * @param string $operand
     * @return $this
     */
    public function addHaving($condition, $operand = self::OperatorAND){
        if(count($this->arrHaving)) $this->arrHaving[] = $operand;
        $this->arrHaving[] = $condition;

        return $this;
    }

    /**
     * @param string $condition
     * @param string $operand
     * @return $this
     */
    public function having($condition, $operand = self::OperatorAND){
        return $this->addHaving($condition, $operand);
    }

    /**
     * @param string $condition
     * @param string $operand
     * @return $this
     */
    public function setHaving($condition, $operand = self::OperatorAND){
        return $this->clearHaving()
            ->addHaving($condition, $operand);
    }

    /**
     * @return $this
     */
    public function clearHaving(){
        $this->arrHaving = [];

        return $this;
    }

    /**
     * @param int $limit
     * @param bool $offset
     * @return $this
     */
    public function setLimit($limit, $offset = false){
        $this->limit = (int)$limit;
        if($offset!==false) $this->offset = (int)$offset;

        return $this;
    }

    const UNION = 'UNION';
    const UNION_ALL = 'UNION ALL';

    /**
     * @param string|self $table
     * @param string $union
     */
    private function _addUnion($table, $union = self::UNION){
        $this->arrUnion[] = $union;
        if($table instanceof self){
            $this->arrUnion[] = '('.$table->getText().')';
            $this->_mergeParams($table->arrParams);
        } else
            $this->arrUnion[] = $table;
    }

    /**
     * @param string|array|self $table
     * @return $this
     */
    public function addUnion($table){
        if(is_array($table)){
            foreach ($table as $t){
                $this->_addUnion($t);
            }
        } else
            $this->_addUnion($table);

        return $this;
    }

    /**
     * @param array $tables
     * @return $this
     */
    public function union($tables=[]){
//        $this->reset();
        $this->addUnion($tables);

        return $this;
    }

    /**
     * @param string|array|self $table
     * @return $this
     */
    public function addUnionAll($table){
        if(is_array($table)){
            foreach ($table as $t){
                $this->_addUnion($t, self::UNION_ALL);
            }
        } else
            $this->_addUnion($table, self::UNION_ALL);

        return $this;
    }

    /**
     * @param array $tables
     * @return $this
     */
    public function unionAll($tables=[]){
//        $this->reset();
        $this->addUnionAll($tables);

        return $this;
    }

    /**
     * @return $this
     */
    public function clearUnion(){
        $this->arrUnion = [];

        return $this;
    }

    /**
     * @return array
     */
    private function _buildQueryBySection(){
        $newLine = chr(13).chr(10);
        $countArrFrom = count($this->arrFrom);
        $countArrUnion = count($this->arrUnion);

        switch ($this->distinct){
            case self::DISTINCT :
                $this->sql['select'] = 'SELECT DISTINCT'; break;
            case self::DISTINCT_ROW :
                $this->sql['select'] = 'SELECT DISTINCTROW'; break;
            default:
                $this->sql['select']= 'SELECT';
        }

        $this->sql['select'].=' '.(count($this->arrSelect) ? implode($newLine.", ", $this->arrSelect) : '*');

        $this->sql['from'] = '';
        if($countArrFrom)
            $this->sql['from'].="\nFROM ".implode($newLine.", ", $this->arrFrom);
//        else if (!$countArrUnion)
//            throw new CDbException(Yii::t('yii','The DB query must contain the "from" portion.'));

        $this->sql['join'] = '';
        if(count($this->arrJoin))
            $this->sql['join'].="\n".implode(" \n".$newLine, $this->arrJoin);

        $this->sql['where'] = '';
        if(count($this->arrWhere))
            $this->sql['where'].="\nWHERE ".implode(" ".$newLine, $this->arrWhere);

        $this->sql['group'] = '';
        if(count($this->arrGroup))
            $this->sql['group'].="\nGROUP BY ".implode($newLine.", ", $this->arrGroup);

        $this->sql['having'] = '';
        if(count($this->arrHaving))
            $this->sql['having'].="\nHAVING ".implode(" ".$newLine, $this->arrHaving);

        $this->sql['union'] = '';
        if($countArrUnion){
            $arrUnion = $this->arrUnion;
            if($countArrFrom) $this->sql['union'].="\n";
            else {
                $this->sql = [];
                $this->sql['union'] = "";
                array_shift($arrUnion);
            }
            $this->sql['union'].="(\n" . implode("\n", $arrUnion) . "\n)";
        }

        $this->sql['order'] = '';
        if(count($this->arrOrder))
            $this->sql['order'].="\nORDER BY ".implode($newLine.", ", $this->arrOrder);

        $this->sql['limit'] = '';
        if($this->limit>=0 || $this->offset>0)
            $this->sql['limit']=$this->connection->getCommandBuilder()->applyLimit('', $this->limit, $this->offset);

        return $this->sql;
    }

    /**
     * @return string
     */
    private function _buildQuery(){
        return implode(" ", $this->sql);
    }

    /**
     * @param $value
     * @return string|string[]|null
     */
    private function _setText($value)
    {
        if($this->connection->tablePrefix!==null && $value!='')
            $sql=preg_replace('/{{(.*?)}}/',$this->connection->tablePrefix.'\1',$value);
        else
            $sql=$value;

        return $sql;
    }

    /**
     * @return string|string[]|null
     */
    public function getText(){
        $this->_buildQueryBySection();
        return $this->_setText($this->_buildQuery());
    }

    /**
     * @return mixed|string|string[]|null
     */
    public function getQuery(){
        $query = $this->getText();
        foreach ($this->arrParams as $k => $v){
            $val = is_string($v)? "'$v'" : $v;
            $query = str_replace($k, $val, $query);
        }
        return $query;
    }

    private function _prepare($skipbuildQueryBySection = false){
        if(!$skipbuildQueryBySection)
            $this->_buildQueryBySection();
        $this->cmd = $this->connection->createCommand();
        $this->cmd->setText($this->_buildQuery());
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function query($params = []){
        $this->_prepare();
        return $this->cmd->query(count($params)? array_merge($this->arrParams, $params):$this->arrParams);
    }

    /**
     * @param bool $fetchAssociative
     * @param array $params
     * @return mixed
     */
    public function queryAll($fetchAssociative=true, $params = []){
        $this->_prepare();
        return $this->cmd->queryAll($fetchAssociative, count($params)? array_merge($this->arrParams, $params):$this->arrParams);
    }

    /**
     * @param bool $fetchAssociative
     * @param array $params
     * @return mixed
     */
    public function queryRow($fetchAssociative=true, $params = []){
        $this->_prepare();
        return $this->cmd->queryRow($fetchAssociative, count($params)? array_merge($this->arrParams, $params):$this->arrParams);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function queryScalar($params = []){
        $this->_prepare();
        return $this->cmd->queryScalar(count($params)? array_merge($this->arrParams, $params):$this->arrParams);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function queryColumn($params = []){
        $this->_prepare();
        return $this->cmd->queryColumn(count($params)? array_merge($this->arrParams, $params):$this->arrParams);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function queryCount($params = []){
        $this->_buildQueryBySection();
        $this->sql['select'] = 'SELECT COUNT(*)';
        $this->_prepare(true);
        return $this->cmd->queryScalar(count($params)? array_merge($this->arrParams, $params):$this->arrParams);
    }

    /**
     * The alias name,
     * Will be used when applied as subquery
     * @param string $alias
     * @return $this
     */
    public function setAs($alias){
        $this->as = $alias;

        return $this;
    }

    /**
     * @return string
     */
    public function getWhere(){
        return implode(" ", $this->arrWhere);
    }

    /**
     * @return $this
     */
    public function duplicate(){
        return clone $this;
    }

    /**
     * @param string $table
     * @param string|self $condition
     * @param array $params
     * @return int
     */
    public function delete($table = '', $conditions = '', $params = []){
        if($table) $this->addFrom($table);
        if($conditions) $this->_addCondition($conditions);

        $this->cmd = $this->connection->createCommand();
        return $this->cmd->delete(
            implode(", ", $this->arrFrom),
            implode(" ", $this->arrWhere),
            count($params)? array_merge($this->arrParams, $params):$this->arrParams
        );
    }

    /**
     * @param $field
     * @param string|self $value
     * @return $this
     */
    public function set($column, $value){
        if($value instanceof self){
            $val = '('.$value->getText().')';
            $this->_mergeParams($value->arrParams);
        } else {
            $val = $value;
        }
        $this->arrUpdateFields[$column] = $val;

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setColumns($columns = []){
        foreach ($columns as $column => $value){
            $this->set($column, $value);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearSet(){
        $this->arrUpdateFields = [];

        return $this;
    }

    /**
     * @param string $table
     * @param array $columns
     * @param string|self $conditions
     * @param array $params
     * @return int
     */
    public function update($table = '', $columns = [], $conditions = '', $params = []){
        if($table) $this->addFrom($table);
        if(count($columns)) $this->setColumns($columns);
        if($conditions) $this->_addCondition($conditions);

        $this->cmd = $this->connection->createCommand();
        return $this->cmd->update(
            implode(", ", $this->arrFrom),
            $this->arrUpdateFields,
            implode(" ", $this->arrWhere),
            count($params)? array_merge($this->arrParams, $params):$this->arrParams
        );
    }

    /**
     * @return mixed
     */
    static function uuid(){
        return Yii::app()->db->createCommand("SELECT UUID();")->queryScalar();
    }

    /**
     * @return mixed
     */
    static function now(){
        return Yii::app()->db->createCommand("SELECT NOW();")->queryScalar();
    }

    public function whereBu($bu_id) {
        return $this->addCondition("p.cabang_id in (".
            DbCmd::instance()->addFrom("{{bu}}")->addSelect("c.cabang_id")
                ->addCondition("bu_id = :bu_id")->addParam(":bu_id", $bu_id)->getQuery()
            .")");
    }
}