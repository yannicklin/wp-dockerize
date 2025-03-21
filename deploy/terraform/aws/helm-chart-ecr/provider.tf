provider "aws" {
  region = "ap-southeast-2"

  default_tags {
    tags = {
      "ctm:environment"     = var.ENVIRONMENT_SHORT
      "ctm:vertical"        = "devops"
      "ctm:role"            = "deployment"
      "ctm:confidentiality" = "restricted"
      "ctm:contains-pii"    = "++NOTSET++"
      "ctm:terraform"       = var.ECR_REPO_NAME
    }
  }
}
