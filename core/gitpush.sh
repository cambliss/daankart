#!/bin/bash
current_branch=$(git branch --show-current)
eval "$(ssh-agent -s)" # start ssh agent
ssh-add ./identity/myrsa_github.pem # add ssh key to agent 
git pull origin $current_branch # pull latest changes from origin
git push origin $current_branch # push changes to origin
ssh-add -d ./identity/myrsa_github.pem # remove ssh key from agent