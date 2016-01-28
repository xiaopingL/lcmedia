	$(document).ready(function() {

        $('.form_validation_ttip').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                classType:{required: true},
                className:{required: true},
                indexName:{required:true},    
                nickname:{required:true},
                loginName:{required:true},
                email:{required:true},
                password:{required:true},
                phone:{required:true},
                name:{required:true},
                url:{required:true},

                areaName:{required:true},
                seoKey:{required:true},
                seoMemo:{required:true},

            },
            messages: {
                classType:'选择类型！',
                className:'请输入内容！',
                indexName:'索引不能为空！',
                nickname:'请输入用户昵称',
                loginName:'请输入登录名称',
                email:'请输入邮箱',
                password:'请输入密码',
                phone:'请输入手机号',
                name:'请输入名称',
                url:'请输入URL',

                areaName:'请输入区域名称',
                seoKey:'请输入SEO关键字',
                seoMemo:'请输入SEO描述',
            },
            highlight: function(element) {
                $(element).closest('tr').addClass("f_error");
            },
            unhighlight: function(element) {
                $(element).closest('tr').removeClass("f_error");
            },
            errorPlacement: function(error, element) {
                $(element).closest('tr').append(error);
            },
            errorPlacement: function(error, element) {
                // Set positioning based on the elements position in the form
                var elem = $(element);

                // Check we have a valid error message
                if(!error.is(':empty')) {
                    if( (elem.is(':checkbox')) || (elem.is(':radio')) ) {
                        // Apply the tooltip only if it isn't valid
                        elem.filter(':not(.valid)').parent('label').parent('div').find('.error_placement').qtip({
                            overwrite: false,
                            content: error,
                            position: {
                                my: 'left bottom',
                                at: 'center right',
                                viewport: $(window),
                                adjust: {
                                    x: 6
                                }
                            },
                            show: {
                                event: false,
                                ready: true
                            },
                            hide: false,
                            style: {
                                classes: 'ui-tooltip-red ui-tooltip-rounded' // Make it red... the classic error colour!
                            }
                        })
                            // If we have a tooltip on this element already, just update its content
                            .qtip('option', 'content.text', error);
                    } else {
                        // Apply the tooltip only if it isn't valid
                        elem.filter(':not(.valid)').qtip({
                            overwrite: false,
                            content: error,
                            position: {
                                my: 'bottom left',
                                at: 'top right',
                                viewport: $(window),
                                adjust: { x: -8, y: 6 }
                            },
                            show: {
                                event: false,
                                ready: true
                            },
                            hide: false,
                            style: {
                                classes: 'ui-tooltip-red ui-tooltip-rounded' // Make it red... the classic error colour!
                            }
                        })
                            // If we have a tooltip on this element already, just update its content
                            .qtip('option', 'content.text', error);
                    };

                }
                // If the error is empty, remove the qTip
                else {
                    if( (elem.is(':checkbox')) || (elem.is(':radio')) ) {
                        elem.parent('label').parent('div').find('.error_placement').qtip('destroy');
                    } else {
                        elem.qtip('destroy');
                    }
                }
            }
        });

	});
