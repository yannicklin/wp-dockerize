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
variable "NAMESPACE" {
  type        = string
  description = "Namespace for the K8s deployment"
}
variable "FEATURE" {
  type        = string
  description = "Name of the feature if applicable"
  default     = ""
}
variable "ECR_REPO_NAME" {
  type        = string
  description = "Image for the ECR Repository"
}
variable "ECR_VERSION" {
  type        = string
  description = "Image for the ECR Repository"
}
variable "HELM_VERSION" {
  type        = string
  description = "Image for the ECR Repository"
}
variable "VERTICAL" {
  type        = string
  description = "Vertical we are building for"
}
variable "ARGOCD_CREDS" {
  description = "Argocd credentials as json"
  sensitive   = true
}
variable "ARGOCD_DOMAIN" {
  type        = string
  description = "Argocd endpoint"
}
variable "CF_ACCESS_ID" {
  description = "Access ID for service token"
  type        = string
  sensitive   = true
}
variable "CF_ACCESS_SECRET" {
  description = "Access Secret for service token"
  type        = string
  sensitive   = true
}
variable "CLOUDFLARE_ACCOUNT_ID" {
  type        = string
  description = "Cloudflare Account id"
}
variable "NEW_RELIC_API_KEY" {
  description = "API Key for New Relic operations"
  type        = string
  sensitive   = true
}
