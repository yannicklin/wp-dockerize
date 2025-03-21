terraform {
  # Note, this is a partial Terraform backend configuration. The missing arguments are passed at runtime
  # https://www.terraform.io/docs/language/settings/backends/configuration.html#partial-configuration
  backend "s3" {
    encrypt = "true"
  }
}
