<?php
class ByPatronType extends Report {

	/**
	 * store report information: name of report and description of report
	 * @return					:	an array containing info on the report
	 */
	function info() {
		$report_info["name"] = "Questions by Patron Type";
		$report_info["desc"] = "This report provides the count of questions for every patron type.";
		return ($report_info);
	}


	/**
	 * the SQL query/statement for the report
	 * @param	=		sql		:	the WHERE clause clauses
	 * @param	=		param	: parameters from the form
	 * @return					: result of perform the SQL query	
	 */
	function perform($sql, $param) {
		// don't lose the db!
    $db = $_REQUEST['db'];
    $this->db = $db;

		// gather $result
    $fullQuery = "SELECT COUNT(questions.question) as questions, patron_types.patron_type as patrons
			FROM questions
			JOIN patron_types ON
			(questions.patron_type_id = patron_types.patron_type_id)
			$sql
			GROUP BY patrons";

    $result = $this->db->getAll($fullQuery, $param);
		return $result;
	}


	/**
	 * display the results of the report
	 * @param	=	rInfo			:	a multi-dimensional array pertaining to the report, including results
	 */
	function display($rInfo) {
		#echo "<h3>rInfo</h3><pre>"; print_r($rInfo); echo "</pre>";

		echo "<h3>{$rInfo['library_name']}";
		if (isset($rInfo['location_name'])){
			echo " > location: {$rInfo['location_name']}";
		}

    // format the start and end dates
    $dateStart = (date('Ymd',strtotime($rInfo['date1'])));
    $dateEnd = (date('Ymd',strtotime($rInfo['date2'])));

		echo "</h3><h3>{$rInfo['reportList']['name']} from $dateStart through $dateEnd- Full Report</h3>";
		// ^^ the above is a standard header ^^


    // make my report table header...
    echo '<table id= "questionTable">
            <tr>
                <th>Patron Type</th>
                <th>Question Count</th>
                <th>Percentage</th>
            </tr>
						<tbody>';
    // get my report table data...
    $i = 0;
    $count = array();
    $percentage = array();
		$numberReportQuestionCount = $rInfo['reportQuestionCount'] + 0;

    foreach ($rInfo["reportResults"] as $report) {
			echo "<tr>
							<td>{$report["patrons"]}</td>
							<td>" . ($report["questions"] + 0) . "</td>
							<td>" . round(((($report["questions"] + 0) / $numberReportQuestionCount)*100), 1) . "%</td>
					</tr>";
			$i++;
			$arrayCount = $i;
			$count[$arrayCount] = $report["questions"];
			$percentage[$arrayCount] = round(((($report["questions"] + 0) / $numberReportQuestionCount)*100), 1);    
    }

    // total report summary
    $questionSum = array_sum($count);
    $questionPercentage = array_sum($percentage);
    echo "</tbody>
					<tr>
            <td><strong>Totals</strong></td>
            <td><strong>$questionSum</strong></td>
            <td><strong>$questionPercentage%</strong></td>
          </tr></table>";
	}


	/**
	 * still unclear why this is here; inherited from previous method of reporting
	 * @return						: true
	 */
	function isAuthenticationRequired() {
		return true;
	}
}
?>
