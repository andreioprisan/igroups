			<div style="float:right; line-height:18px;" id="login" >
				<?= $this->lang->line('us_en_welcome'); ?>!<br />
				<a href="javascript:makelogin()" ><?= $this->lang->line('us_en_login'); ?></a> | 
				<a id='registerlink' href="/adm/redirect/registration/register.php?m_PR=18"><?= $this->lang->line('us_en_register'); ?></a>
				<script>
					$('#registerlink').attr('href','/adm/redirect/registration/register.php?m_PR=18&m_AID=' + aid );
				</script>
			</div>
