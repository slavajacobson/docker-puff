# -*- encoding: utf-8 -*-
# stub: capistrano-git-with-submodules 2.0.3 ruby lib

Gem::Specification.new do |s|
  s.name = "capistrano-git-with-submodules".freeze
  s.version = "2.0.3"

  s.required_rubygems_version = Gem::Requirement.new(">= 1.3.6".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Boris Gorbylev".freeze]
  s.date = "2017-03-26"
  s.description = "Git submodules support for Capistrano 3.7+".freeze
  s.email = ["ekho@ekho.name".freeze]
  s.extra_rdoc_files = ["README.md".freeze, "LICENSE".freeze]
  s.files = ["LICENSE".freeze, "README.md".freeze]
  s.homepage = "https://github.com/ekho/capistrano-git-with-submodules".freeze
  s.licenses = ["MIT".freeze]
  s.rubygems_version = "3.0.3".freeze
  s.summary = "Git submodules support for Capistrano 3.7+".freeze

  s.installed_by_version = "3.0.3" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_runtime_dependency(%q<capistrano>.freeze, ["~> 3.7"])
    else
      s.add_dependency(%q<capistrano>.freeze, ["~> 3.7"])
    end
  else
    s.add_dependency(%q<capistrano>.freeze, ["~> 3.7"])
  end
end
