<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('fileUpload'))
{
	function fileUpload($field)
	{
		$CI	=& get_instance();
		$upload_config	= $CI->config->item('upload_config');
		$upload_config['upload_path'] = makeDir($CI->config->item('upload_path'));
		$CI->load->library('upload', $upload_config);
		if (!$CI->upload->do_upload($field))
			return $CI->upload->display_errors();
		else
			return  $CI->upload->data();
	}
}



/* End of file array_helper.php */
/* Location: ./system/helpers/array_helper.php */