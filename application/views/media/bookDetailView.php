<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<form method="post" action="" class="form_validation_ttip" novalidate="novalidate" id="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td colspan="4" style="text-align: center;font-weight: bold;font-size:18px;color:green">领程传媒包场活动确认单</td>
		    </tr>
		    
		    <tr>
                <td style="text-align: center;font-weight: bold;">客户名称</td>
                <td><?php echo $name;?></td>
                <td style="text-align: center;font-weight: bold;">活动性质</td>
                <td><?php echo $advert['nature'][$nature];?></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">执行影院</td>
                <td><?php echo $studioList[$studioId];?></td>
                <td width="10%" style="text-align: center;font-weight: bold;">影片类型</td>
                <td><?php echo $advert['film_type'][$film_type];?></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">片名</td>
                <td><?php echo $film_name;?></td>
                <td width="10%" style="text-align: center;font-weight: bold;">厅号</td>
                <td><?php echo $hallNumber;?></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">执行时间</td>
                <td><?php echo date('Y-m-d',$follow_date);?></td>
                <td width="10%" style="text-align: center;font-weight: bold;">人数</td>
                <td><?php echo $person_num;?></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">执行票价</td>
                <td><?php echo $film_price;?>&nbsp;（元/张）</td>
                <td width="10%" style="text-align: center;font-weight: bold;">卖品需求</td>
                <td><?php echo $demand_price;?>&nbsp;（元/套）&nbsp;&nbsp;（<?php echo $demand_num;?>份）</td>
            </tr>
            
            <tr>
                <td style="text-align: center;font-weight: bold;">客户报价情况</td>
                <td colspan="3">
                    <table cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td style="text-align: center;"><b>影票报价(元/张)</b></td>
                            <td style="text-align: center;"><b>卖品报价(元/套)</b></td>
                            <td style="text-align: center;"><b>税费(元)</b></td>
                            <td style="text-align: center;"><b>服务费(元)</b></td>
                            <td style="text-align: center;"><b>物料制作费(元)</b></td>
                            <td style="text-align: center;"><b>其他(元)</b></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?php echo $contentList[0];?></td>
                            <td style="text-align: center;"><?php echo $contentList[1];?></td>
                            <td style="text-align: center;"><?php echo $contentList[2];?></td>
                            <td style="text-align: center;"><?php echo $contentList[3];?></td>
                            <td style="text-align: center;"><?php echo $contentList[4];?></td>
                            <td style="text-align: center;"><?php echo $contentList[5];?></td>
                        </tr>
                        <tr>
                            <td colspan="6">费用总计：<?php echo $total;?>&nbsp;（元）</td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">情况说明</td>
                <td colspan="3"><?php echo $remark;?></td>
            </tr>
            
            <?php if(!empty($contractId)){?>
            <tr>
                <td style="text-align: center;font-weight: bold;">合同信息</td>
                <td colspan="3">
                    <table cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td style="text-align: center;"><b>合同编号</b></td>
                            <td style="text-align: center;"><b>合同名称</b></td>
                            <td style="text-align: center;"><b>合同金额(元)</b></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?php echo $contractList['contractNumber'];?></td>
                            <td style="text-align: center;"><a href="<?php echo site_url('/business/ContractController/contractDetail/'.$contractId);?>" target="_blank"><?php echo $contractList['title'];?></a></td>
                            <td style="text-align: center;"><?php echo $contractList['money'];?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php } ?>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">审批详情</td>
                <td colspan="3"><?php echo $this->load->view('index/approveDetail'); ?></td>
            </tr>
        </tbody>
    </table>
</form>
