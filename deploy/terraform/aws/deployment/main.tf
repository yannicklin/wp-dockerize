resource "random_string" "guid" {
  length  = 8
  lower   = true
  upper   = false
  special = false
}

module "deployment" {
  source  = "app.terraform.io/ctmaus/ctm-enterprise-wordpress/enterprise"
  version = "1.8.0"

  AWS_REGION            = var.AWS_REGION
  EKS_CLUSTER_NAME      = data.terraform_remote_state.kubernetes.outputs.AWS_CLUSTER_NAME
  AWS_OIDC_ARN          = data.terraform_remote_state.kubernetes.outputs.AWS_OIDC_ARN
  AWS_OIDC_ISSUER_URL   = data.terraform_remote_state.kubernetes.outputs.AWS_OIDC_ISSUER_URL
  ENVIRONMENT           = var.ENVIRONMENT
  ENVIRONMENT_SHORT     = var.ENVIRONMENT_SHORT
  ECR_REPO_NAME         = var.ECR_REPO_NAME
  ECR_VERSION           = var.ECR_VERSION
  HELM_VERSION          = var.HELM_VERSION
  VERTICAL              = var.VERTICAL
  NAMESPACE             = "${lower(var.NAMESPACE)}-${local.namespace_uniq}"
  MESH_NAME             = "ap-southeast-${var.ENVIRONMENT_SHORT}"
  FEATURE               = var.FEATURE
  CONTAINER_PORT        = 8080
  GUID                  = local.namespace_uniq
  CLOUDFLARE_ACCOUNT_ID = var.CLOUDFLARE_ACCOUNT_ID
  NEW_RELIC_API_KEY     = var.NEW_RELIC_API_KEY
  VPC_ID                = data.terraform_remote_state.kubernetes.outputs.VPC_ID
}