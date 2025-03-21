data "aws_ssm_parameter" "cloudflare" {
  name = "/ctm/${var.ENVIRONMENT}/cloudflare"
}