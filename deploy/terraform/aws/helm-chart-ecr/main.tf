module "ecr" {
  source = "app.terraform.io/ctmaus/ecr/devops"
  version = "1.0.0"

  AWS_REGION = var.AWS_REGION
  ENVIRONMENT = var.ENVIRONMENT
  ENVIRONMENT_SHORT = var.ENVIRONMENT_SHORT
  ECR_REPO_NAME = var.ECR_REPO_NAME
}

module "s3_bucket_wordpress" {
  source  = "cloudposse/s3-bucket/aws"
  version = "3.1.2"

  bucket_name             = "ctm-enterprise-wordpress-common"
  s3_object_ownership     = "BucketOwnerEnforced"
  versioning_enabled      = true
  enabled                 = true
  allow_ssl_requests_only = true

  privileged_principal_actions   = [
    "s3:GetObject",
    "s3:ListBucket",
    "s3:GetBucketLocation",
    "s3:PutObject",
    "s3:GetObjectTagging",
    "s3:PutObjectTagging"
  ]
  privileged_principal_arns      = [
    {
      "arn:aws:iam::${local.accounts.dev}:root" = [""],
    },
    {
      "arn:aws:iam::${local.accounts.stg}:root" = [""],
    },
    {
      "arn:aws:iam::${local.accounts.prd}:root" = [""],
    }
  ]

  tags = {
    "ctm:confidentiality" = "restricted"
    "ctm:contains-pii"    = "no"
    "ctm:name"            = "terraform wordpress data sync"
    "ctm:role"            = "backup"
    "ctm:vertical"        = "enterprise"
    "ctm:terraform"       = "terraform-enterprise-ctm-enterprise-wordpress"
  }
}