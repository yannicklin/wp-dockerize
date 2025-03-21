terraform {
  required_version = ">= 1.3.5"

  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = ">=5.0.0"
    }
    local = {
      source = "hashicorp/local"
    }
    argocd = {
      source = "oboukili/argocd"
      version = "< 7.0.0"
    }
    cloudflare = {
      source = "cloudflare/cloudflare"
      version = ">= 4.0.0"
    }
    newrelic = {
      source = "newrelic/newrelic"
      version = "~> 3.27.1"
    }
  }
}