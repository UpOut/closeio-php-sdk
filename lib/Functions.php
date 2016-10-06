<?php
  function check_existing_lead($email) {

    $lead_data = new StdClass();
    $lead = new Closeio\Lead();
    $query = "email:".$email;
    $lead_data->query = $query;

    $lead_data->_limit = 1;
    $lead_data->_fields = "id,display_name";

    $result = $lead->read($lead_data);

    if ($result->total_results > 0) {
        return TRUE;
        
    } else if ($result->total_results == 0 ) {
        return FALSE; 
    } else { return FALSE; }

  }

# Check if eb org id exists, if it does, return the email, original_url and name
    function check_existing_eborgid($eb_org_id) {
        $lead_data = new StdClass();
        $lead = new Closeio\Lead();
        $query = "custom.eb_org_id:".$eb_org_id;
        $lead_data->query = $query;

        $lead_data->_limit = 1;
       # $lead_data->_fields = "id,display_name,url,custom.eb_org_id";

        $result = $lead->read($lead_data);
        $result_data = new StdClass();
        $result_data->total_results = $result->total_results;

        if($result_data->total_results > 0) {
            if (isset( $result->data[0]->custom->{'MR Lead'})) { 
                $result_data->{'MR Lead'} = $result->data[0]->custom->{'MR Lead'};
            }
            if (isset( $result->data[0]->contacts[0]->emails[0]->email)) { 
                $result_data->email = $result->data[0]->contacts[0]->emails[0]->email;
            }
            $result_data->display_name = $result->data[0]->display_name;
            $result_data->url = $result->data[0]->url;
            $result_data->id = $result->data[0]->id;
        }



        return array($result_data, $lead);
        

    }

?>
