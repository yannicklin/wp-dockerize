variable "AWS_REGION" {
  type        = string
  description = "AWS region"
  default     = "ap-southeast-2"
}
variable "ENVIRONMENT" {
  type        = string
  description = "Staging environment name"
}
variable "ENVIRONMENT_SHORT" {
  type        = string
  description = "Short environment name"
}
variable "ECR_REPO_NAME" {
  type        = string
  description = "Image for the ECR Repository"
}