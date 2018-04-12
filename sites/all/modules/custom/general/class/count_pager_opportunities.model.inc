<?php
/**
 *  classes Function Form search content Job
 */
class career {
  /* Define machine name of connection. */
  const NAME = 'careers_job ';
  
  /* get job for right sidebar content_career_job_count */
  public static function getCareerRecent() {
  	$query = db_select('node', 'n')
      ->condition('status', 1)
      ->condition('type', self::NAME);
    $query->leftJoin('field_data_field_department', 'd', 'd.entity_id=n.nid');
    $query->addField('d', 'field_department_tid', 'tax');
    $query->groupBy('d.field_department_tid');
    $query->addExpression('COUNT(n.nid)', 'ncount');
    $result = $query->execute()->fetchAll();
    $career = array();
    foreach ($result as $item) {
      $term = taxonomy_term_load($item->tax);
      $career[$item->tax] = array($term->name,$item->ncount);
    }
    return !empty($career) ? $career : array();
  }
  /* Get options for search page career_opportunities. @return NULL|multitype: */
  public static function getSearchOptions ($department, $office) {
    $data =array();
    $query = db_select('node', 'n')
    ->fields('n', array('nid', 'title'))
    ->condition('status', 1)
    ->condition('type', self::NAME);

    $query->leftJoin('field_data_field_department', 'd', 'd.entity_id=n.nid');
    $query->addField('d', 'field_department_tid', 'department');
     if (!empty($department) && $department != 'All') {
      $query->condition('d.field_department_tid', $department);
    }

    $query->leftJoin('field_data_field_offices', 'o', 'o.entity_id=n.nid');
    $query->addField('o', 'field_offices_tid', 'office');
    if (!empty($office) && $office != 'All') {
      $query->condition('o.field_offices_tid', $office);
    }
    $result = $query->execute()->fetchAll();
    $data['department'] = array();
    $data['office'] = array();
    foreach ($result as $item) {
      if(!in_array($item->department, $data['department'])) {
        $data['department'][$item->department] = $item->department;
      }
      if(!in_array($item->office, $data['office'])) {
        $data['office'][$item->office] = $item->office;
      }
    }
    return $data;
	}
}


/**
 *  classes Function Next/Prev of block content_case_study_pager For content Case Study.
 */
class portfolio {
  /* Define machine name of connection. */
  const NAME = 'case_study';

  /* get previous node */
  public static function getPreCaseStudy() {
    if(arg(0)=='node' && is_numeric(arg(1))){
      $nid = arg(1);
      $query = new EntityFieldQuery();
      $query->entityCondition('entity_type', 'node')
        ->entityCondition('bundle', self::NAME)
        ->propertyCondition('status', NODE_PUBLISHED)
        ->propertyCondition('nid', $nid, '<')
        ->range(0, 1);
      $result = $query->execute();
      return !empty($result) ?current($result['node'])->nid : NULL ;
    }
    return array();
  }
  /* get next node */
  public static function getNextCaseStudy() {
    if(arg(0)=='node' && is_numeric(arg(1))){
      $nid = arg(1);
      $query = new EntityFieldQuery();
      $query->entityCondition('entity_type', 'node')
        ->entityCondition('bundle', self::NAME)
        ->propertyCondition('status', NODE_PUBLISHED)
        ->propertyCondition('nid', $nid, '>')
        ->range(0, 1);
      $result = $query->execute();
      return !empty($result) ?current($result['node'])->nid : NULL ;
    }
    return array();
  }
  /* get random node */
  public static function getRandomCaseStudy() {
    if(arg(0)=='node' && is_numeric(arg(1))){
      $nid = arg(1);
      $query = new EntityFieldQuery();
      $query->entityCondition('entity_type', 'node')
        ->entityCondition('bundle', self::NAME)
        ->propertyCondition('status', NODE_PUBLISHED);
      $result = $query->execute();
      $rand = array_rand($result['node'], 1);
      return $rand;
    }
    return array();
  }
}